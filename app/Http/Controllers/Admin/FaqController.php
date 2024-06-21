<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    // public function index(Request $request)
    // {
    //     $keyword = $request->get('search');
    //     $perPage = 15;

    //     if (!empty($keyword)) {
    //         $faq = Faq::where('title', 'LIKE', "%$keyword%")->orWhere('desc', 'LIKE', "%$keyword%")
    //             ->orderBy('id', 'asc')->paginate($perPage);
    //     } else {
    //         $faq = Faq::orderBy('id', 'asc')->paginate($perPage);
    //     }

    //     return view('admin.faq.index', compact('faq'));
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pesonality = Faq::all();
            return DataTables::of($pesonality)
                ->addIndexColumn()
                ->addColumn('question', function ($item) {
                    return $item->question;
                })
                ->addColumn('answer', function ($item) {
                    $answer = html_entity_decode($item->answer, ENT_QUOTES, 'UTF-8');
                    $words = explode(' ', $answer);

                    if (count($words) > 10) {
                        $limitedDescription = implode(' ', array_slice($words, 0, 5));
                        $return = '<span class="limited-description">' . $limitedDescription . '...</span>';
                        // $return .= '<span class="full-description" style="display:none;">' . $answer . '</span>';
                        $return .= '<button class="see-more-btn" onclick="showFullDescription(this)">See More</button>';
                    } else {
                        $return = '<span class="full-description">' . $answer . '</span>';
                    }

                    return $return;
                })
                ->addColumn('action', function ($item) {
                    $return = '';
                    $return .= '<a href="' . url("/admin/faq/" . $item->id) . '" title="View Personality"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> ';
                    $return .= '<a href="' . url("/admin/faq/" . $item->id . "/edit") . '" title="Edit Personality"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a> ';
                    $return .= '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove Faq" data-remove="' . url("/admin/faq/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
                    return $return;
                })
                ->rawColumns(['question', 'answer', 'action'])
                ->make(true);
        }
        return view('admin.faq.index');
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {

        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'question' => 'required',
                'answer' => 'required',
                'question_hi' => 'nullable|string',
                'question_ja' => 'nullable|string',
                'question_es' => 'nullable|string',
                'question_fr' => 'nullable|string',
                'question_it' => 'nullable|string',
                'question_ru' => 'nullable|string',
                'question_de' => 'nullable|string',
                'answer_hi' => 'nullable|string',
                'answer_ja' => 'nullable|string',
                'answer_es' => 'nullable|string',
                'answer_de' => 'nullable|string',
                'answer_fr' => 'nullable|string',
                'answer_it' => 'nullable|string',
                'answer_ru' => 'nullable|string',
            ]
        );

        $data = $request->all();

        $Faq = Faq::create($data);

        return redirect('admin/faq')->with('flash_message', 'Faq added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $faq = Faq::findOrFail($id);

        return view('admin.faq.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'question' => 'required',
                'answer' => 'required',
                'question_hi' => 'nullable|string',
                'question_ja' => 'nullable|string',
                'question_es' => 'nullable|string',
                'question_fr' => 'nullable|string',
                'question_it' => 'nullable|string',
                'question_de' => 'nullable|string',
                'question_ru' => 'nullable|string',
                'answer_hi' => 'nullable|string',
                'answer_ja' => 'nullable|string',
                'answer_es' => 'nullable|string',
                'answer_de' => 'nullable|string',
                'answer_fr' => 'nullable|string',
                'answer_it' => 'nullable|string',
                'answer_ru' => 'nullable|string',
            ]
        );

        $data = $request->all();

        $faq = Faq::findOrFail($id);
        $faq->update($data);

        return redirect('admin/faq')->with('flash_message', 'Faq updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    // public function destroy($id)
    // {
    //     Faq::destroy($id);

    //     return redirect('admin/faq')->with('flash_message', 'Faq deleted!');
    // }
    public function destroy(Request $request, $id)
    {

        $faq = Faq::find($id);
        if ($request->ajax()) {
            if (Faq::destroy($id)) {
                $data = 'Success';
            } else {
                $data = 'Failed';
            }
            return response()->json($data);
        }
        Faq::destroy($id);
        return redirect('admin/faq')->with('flash_message', ' Faq deleted!');
    }
}
