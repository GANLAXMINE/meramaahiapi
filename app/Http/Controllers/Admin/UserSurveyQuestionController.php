<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserSurveyQuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $questions = SurveyQuestion::all();
            // $users = User::all();
            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('category', function ($item) {
                    $return = $item->category;
                    return $return;
                })->addColumn('questions', function ($item) {
                    $return = $item->questions;
                    return $return;
                })->addColumn('description', function ($item) {
                    $return = $item->description;
                    return $return;
                })->addColumn('option_1', function ($item) {
                    $return = $item->option_1;
                    return $return;
                })->addColumn('option_2', function ($item) {
                    $return = $item->option_2;
                    return $return;
                })
                ->addColumn('option_3', function ($item) {
                    return $item->option_3;
                })
                ->addColumn('option_4', function ($item) {
                    return $item->option_4;
                })
                ->addColumn('option_5', function ($item) {
                    return $item->option_5;
                })
                ->addColumn('question_types', function ($item) {
                    $return = $item->question_types;
                    return $return;
                })
                ->addColumn('action', function ($item) {
                    $return = '';
                    $return .= '<a href="' . url("/admin/survey_questions/" . $item->id) . '" title="View Questions"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> ';
                    $return .= '<a href="' . url("/admin/survey_questions/" . $item->id . "/edit") . '" title="Edit Questions"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a> ';
                    $return .= '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove Questions" data-remove="' . url("/admin/survey_questions/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
                    return $return;
                })

                ->rawColumns(['category', 'questions', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'question_types', 'action'])
                ->make(true);
        }
        return view('admin.survey_questions.index');
    }

    public function create()
    {
        // $categoryQuestions = [
        //     '7 Love Styles' => '7 Love Styles',
        //     'PERSONALITY TYPE IS YOUR LOVE MATCH (works in conjunction with Myers Briggs)' => 'PERSONALITY TYPE IS YOUR LOVE MATCH (works in conjunction with Myers Briggs)',
        //     'WHICH ENNEAGRAM TYPE IS YOUR IDEAL PARTNER?' => 'WHICH ENNEAGRAM TYPE IS YOUR IDEAL PARTNER?',
        //     'ENNEAGRAM TEST' => 'ENNEAGRAM TEST',
        //     'Myers Briggs' => 'Myers Briggs',
        //     'Big 5' => 'Big 5'
        // ];

        $questionTypes = [
            'Single Select' =>  'Single Select',
            '3 pt scale' => '3 pt scale',
            '5 pt scale' => '5 pt scale'
        ];

        return view('admin.survey_questions.create', ['questionTypes' => $questionTypes]);
    }

    public function store(Request $request)
    {
        // dd("hello");
        $this->validate(
            $request,
            [
                'category' => 'required',
                'questions' => 'required',
                'option_types' => 'required',
            ]
        );

        $data = [
            'category' => $request->input('category'),
            'questions' => $request->input('questions'),
            'description' => $request->input('description'),
            'option_1' => $request->input('option_1'),
            'option_2' => $request->input('option_2'),
            'option_3' => $request->input('option_3'),
            'option_4' => $request->input('option_4'),
            'option_5' => $request->input('option_5'),
            'option_types' => $request->input('option_types'),
        ];
        // dd($data);

        SurveyQuestion::create($data);

        return redirect('admin/survey_questions')->with('flash_message', 'Questions added!');
    }

    public function show($id)
    {
        try {
            $questions = SurveyQuestion::findOrFail($id);
            return view('admin.survey_questions.show', compact('questions'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "questions doesn't Exist!");
        }
    }

    public function edit($id)
    {
        // $categoryQuestions = [
        //     '7 Love Styles' => '7 Love Styles',
        //     'PERSONALITY TYPE IS YOUR LOVE MATCH (works in conjunction with Myers Briggs)' => 'PERSONALITY TYPE IS YOUR LOVE MATCH (works in conjunction with Myers Briggs)',
        //     'WHICH ENNEAGRAM TYPE IS YOUR IDEAL PARTNER?' => 'WHICH ENNEAGRAM TYPE IS YOUR IDEAL PARTNER?',
        //     'ENNEAGRAM TEST' => 'ENNEAGRAM TEST',
        //     'Myers Briggs' => 'Myers Briggs',
        //     'Big 5' => 'Big 5'
        // ];

        $questionTypes = [
            'Single Select' =>  'Single Select',
            '3 pt scale' => '3 pt scale',
            '5 pt scale' => '5 pt scale'
        ];
        $questions = SurveyQuestion::findOrFail($id);

        return view('admin.survey_questions.edit', ['questionTypes' => $questionTypes, 'questions' => $questions]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category' => 'required',
            'questions' => 'required',
            'option_types' => 'required',
        ]);

        $question = SurveyQuestion::findOrFail($id);

        $data = [
            'category' => $request->input('category'),
            'questions' => $request->input('questions'),
            'description' => $request->input('description'),
            'option_1' => $request->input('option_1'),
            'option_2' => $request->input('option_2'),
            'option_3' => $request->input('option_3'),
            'option_4' => $request->input('option_4'),
            'option_5' => $request->input('option_5'),
            'option_types' => $request->input('option_types'),
        ];

        $question->update($data);

        return redirect('admin/survey_questions')->with('flash_message', 'Questions updated!');
    }



    public function destroy(Request $request, $id)
    {

        $userMatch = SurveyQuestion::find($id);
        if ($request->ajax()) {
            if (SurveyQuestion::destroy($id)) {
                $data = 'Success';
            } else {
                $data = 'Failed';
            }
            return response()->json($data);
        }
        SurveyQuestion::destroy($id);
        return redirect('admin/survey_questions')->with('flash_message', ' Question deleted!');
    }
}
