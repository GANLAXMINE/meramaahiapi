<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personality;
use Yajra\DataTables\DataTables;

class PersonalityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pesonality = Personality::all();
            // dd($pesonality);
            return DataTables::of($pesonality)
                ->addIndexColumn()
                ->addColumn('slug', function ($item) {
                    $return = $item->slug;
                    return $return;
                })
                ->addColumn('description', function ($item) {
                    $description = $item->description_en;
                    $words = explode(' ', $description);
                
                    if (count($words) > 10) {
                        $limitedDescription = implode(' ', array_slice($words, 0, 5));
                        $return = '<span class="limited-description">' . $limitedDescription . '...</span>';
                        $return .= '<span class="full-description" style="display:none;">' . $description . '</span>';
                        $return .= '<button class="see-more-btn" onclick="showFullDescription(this)">See More</button>';
                    } else {
                        $return = $description;
                    }
                
                    return $return;
                })
                ->addColumn('short_description', function ($item) {
                    $description = $item->short_description_en;
                    $words = explode(' ', $description);
                
                    if (count($words) > 10) {
                        $limitedDescription = implode(' ', array_slice($words, 0, 5));
                        $return = '<span class="limited-description">' . $limitedDescription . '...</span>';
                        $return .= '<span class="full-description" style="display:none;">' . $description . '</span>';
                        $return .= '<button class="see-more-btn" onclick="showFullDescription(this)">See More</button>';
                    } else {
                        $return = $description;
                    }
                
                    return $return;
                })
                
                ->addColumn('action', function ($item) {
                    $return = '';
                    $return .= '<a href="' . url("/admin/personalities/" . $item->id) . '" title="View Personality"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> ';
                    $return .= '<a href="' . url("/admin/personalities/" . $item->id . "/edit") . '" title="Edit Personality"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a> ';
                    $return .= '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove Personality" data-remove="' . url("/admin/personalities/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
                    return $return;
                })

                ->rawColumns(['slug', 'description','short_description','action'])
                ->make(true);
        }
        return view('admin.personality.index');
    }

    public function create()
    {

        return view('admin.personality.create');
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'slug' => 'required',
                'short_description_en' => 'required',
                'description_en' => 'required',
            ]
        );

        $data = [
            'slug' => $request->input('slug'),
            'short_description_en' => $request->input('short_description_en'),
            'description_en' => $request->input('description_en'),
        ];

        Personality::create($data);

        return redirect('admin/personalities')->with('flash_message', 'Personality added!');
    }


    public function edit($id)
    {
       
        $personality = Personality::findOrFail($id);

        return view('admin.personality.edit', ['personality' => $personality]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'slug' => 'required',
            'short_description_en' => 'required',
            'description_en' => 'required',
        ]);

        $personality = Personality::findOrFail($id);

        $data = [
            'slug' => $request->input('slug'),
            'short_description_en' => $request->input('short_description_en'),
            'description_en' => $request->input('description_en'),
        ];

        $personality->update($data);

        return redirect('admin/personalities')->with('flash_message', 'Personality updated!');
    }

    public function show($id)
    {
        try {
            $personality = Personality::findOrFail($id);
            return view('admin.personality.show', compact('personality'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "personality doesn't Exist!");
        }
    }

    public function destroy(Request $request, $id)
    {

        $personaliy = Personality::find($id);
        if ($request->ajax()) {
            if (Personality::destroy($id)) {
                $data = 'Success';
            } else {
                $data = 'Failed';
            }
            return response()->json($data);
        }
        Personality::destroy($id);
        return redirect('admin/personalities')->with('flash_message', ' Personality deleted!');
    }
}
