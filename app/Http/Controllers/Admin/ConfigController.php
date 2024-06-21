<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

use App\Models\Configuration as MyModel;
use Illuminate\Support\Facades\DB;
use App\Models\Role;


use Yajra\DataTables\DataTables;

class ConfigController extends Controller
{
    private static $__id = 1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        if (!empty($keyword)) {
            $configuration = MyModel::where('terms_of_use', 'LIKE', "$keyword%")
                ->orWhere('privacy_policy', 'LIKE', "$keyword%")
                ->orWhere('about_us', 'LIKE', "$keyword%")
                // ->orWhere('community_guideline', 'LIKE', "$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $configuration = MyModel::latest()->paginate($perPage);
        }

        return view('admin.configuration.index', compact('configuration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.configuration.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'terms_of_use' => 'required',
            'privacy_policy' => 'required',
            'about_us' => 'required',
            // 'community_guideline' => 'required'
        ];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        // return $validateAttributes
        if ($validateAttributes) :
            $error = $validateAttributes->getData();
            return redirect('admin/configurations/create')->withInput()->with('error', $error->error);
        endif;

        $requestData = $request->all();
        MyModel::create($requestData);

        return redirect('admin/configuration')->with('flash_message', 'Configuration added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $configuration = MyModel::findOrFail($id);

        return view('admin.configuration.show', compact('configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $configuration = MyModel::findOrFail($id);

        return view('admin.configuration.edit', compact('configuration'));
    }

    public function customEdit()
    {
        $id = '1';
        $configuration = MyModel::findOrFail($id);

        return view('admin.configuration.edit', compact('configuration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'terms_of_use' => 'required',
            'privacy_policy' => 'required',
            'about_us' => 'required'
            // 'community_guideline' => 'required'
        ];
        $validateAttributes = parent::validateAttributes($request, 'PATCH', $rules, array_keys($rules), false);
        // return $validateAttributes
        if ($validateAttributes) :
            $error = $validateAttributes->getData();
            return redirect()->back()->withInput()->with('error', $error->error);
        endif;

        $requestData = $request->all();
        //	dd($requestData);
        $configuration = MyModel::findOrFail($id);
        $configuration->update($requestData);
        //dd($configuration);
        return redirect()->back()->with('flash_message', 'Configuration updated!');
        //              return redirect('admin/configuration')->with('flash_message', 'Configuration updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        MyModel::destroy($id);

        return redirect('admin/configuration')->with('flash_message', 'Configuration deleted!');
    }
}