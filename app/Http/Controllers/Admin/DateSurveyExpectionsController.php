<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DateSurveyQuestion;
use App\Models\FirstDateSurveyQuestionOptions;
use App\Models\FirstDateSurveyQuestions;
use Yajra\DataTables\Facades\DataTables;

class DateSurveyExpectionsController extends Controller
{
    /**
     * Display a listing of the date expectations.
     *
     */
    // public function index(Request $request)
    // {
    //     // Check if the request is an AJAX request
    //     if ($request->ajax()) {
    //         // Retrieve all date survey questions
    //         $expections = DateSurveyQuestion::all();

    //         // Return DataTables response for AJAX request
    //         return DataTables::of($expections)
    //             ->addIndexColumn()
    //             ->addColumn('questions', function ($item) {
    //                 // Add column for questions
    //                 $return = $item->questions_en;
    //                 return $return;
    //             })
    //             ->addColumn('option_1', function ($item) {
    //                 // Add column for option 1
    //                 $option = $item->option_1_en;
    //                 $words = explode(' ', $option);
    //                 // Check if option contains more than 5 words
    //                 if (count($words) > 5) {
    //                     $limitedDescription = implode(' ', array_slice($words, 0, 5));
    //                     $return = '<span class="limited-description">' . $limitedDescription . '.....</span>';

    //                 } else {
    //                     $return = $option;
    //                 }
    //                 return $return;
    //             })
    //             ->addColumn('option_2', function ($item) {
    //                 // Add column for option 2
    //                 $option = $item->option_2_en;
    //                 $words = explode(' ', $option);
    //                 // Check if option contains more than 5 words
    //                 if (count($words) > 5) {
    //                     $limitedDescription = implode(' ', array_slice($words, 0, 5));
    //                     $return = '<span class="limited-description">' . $limitedDescription . '.....</span>';
    //                 } else {
    //                     $return = $option;
    //                 }
    //                 return $return;
    //             })
    //             ->addColumn('option_3', function ($item) {
    //                 // Add column for option 3
    //                 $option = $item->option_3_en;
    //                 $words = explode(' ', $option);
    //                 // Check if option contains more than 5 words
    //                 if (count($words) > 5) {
    //                     $limitedDescription = implode(' ', array_slice($words, 0, 5));
    //                     $return = '<span class="limited-description">' . $limitedDescription . '.....</span>';
    //                 } else {
    //                     $return = $option;
    //                 }
    //                 return $return;
    //             })
    //             ->addColumn('action', function ($item) {
    //                 // Add column for actions (view, edit, delete)
    //                 $return = '';
    //                 $return .= '<a href="' . url("/admin/date-expectations/" . $item->id) . '" title="View expectations"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> ';
    //                 $return .= '<a href="' . url("/admin/date-expectations/" . $item->id . "/edit") . '" title="Edit expectations"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a> ';
    //                 // $return .= '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove expectations" data-remove="' . url("/admin/date-expectations/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
    //                 return $return;
    //             })
    //             ->rawColumns(['questions', 'option_1', 'option_2', 'option_3', 'action']) // Specify columns containing HTML
    //             ->make(true); // Return DataTables response
    //     }
    //     // Return view for non-AJAX request
    //     return view('admin.date_expections.index');
    // }
    public function index(Request $request)
    {
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            // Retrieve all questions and their related options
            $questions = FirstDateSurveyQuestions::with('options')->get();

            // Prepare data for DataTables
            $data = $questions->map(function ($question) {
                // Fetch the options for the question
                $options = $question->options->take(3); // Ensure there are at most 3 options

                // Create an array of option texts, ensuring exactly 3 elements
                $optionTexts = $options->pluck('option')->pad(3, '');

                return [
                    'id' => $question->id,
                    'questions' => $question->questions,  // Assuming this is the English version of the question
                    'option_1' => $optionTexts[0],
                    'option_2' => $optionTexts[1],
                    'option_3' => $optionTexts[2],
                ];
            });

            // Return DataTables response for AJAX request
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('questions', function ($row) {
                    return $row['questions'];
                })
                ->addColumn('option_1', function ($row) {
                    $optionText = $row['option_1'];
                    $words = explode(' ', $optionText);
                    if (count($words) > 5) {
                        $limitedDescription = implode(' ', array_slice($words, 0, 5));
                        return '<span class="limited-description">' . $limitedDescription . '.....</span>';
                    }
                    return $optionText;
                })
                ->addColumn('option_2', function ($row) {
                    $optionText = $row['option_2'];
                    $words = explode(' ', $optionText);
                    if (count($words) > 5) {
                        $limitedDescription = implode(' ', array_slice($words, 0, 5));
                        return '<span class="limited-description">' . $limitedDescription . '.....</span>';
                    }
                    return $optionText;
                })
                ->addColumn('option_3', function ($row) {
                    $optionText = $row['option_3'];
                    $words = explode(' ', $optionText);
                    if (count($words) > 5) {
                        $limitedDescription = implode(' ', array_slice($words, 0, 5));
                        return '<span class="limited-description">' . $limitedDescription . '.....</span>';
                    }
                    return $optionText;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . url("/admin/date-expectations/" . $row['id']) . '" title="View expectations"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> '
                        . '<a href="' . url("/admin/date-expectations/" . $row['id'] . "/edit") . '" title="Edit expectations"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>';
                    // . '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove expectations" data-remove="' . url("/admin/date-expectations/" . $row['id']) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
                })
                ->rawColumns(['questions', 'option_1', 'option_2', 'option_3', 'action']) // Specify columns containing HTML
                ->make(true); // Return DataTables response
        }
        // Return view for non-AJAX request
        return view('admin.date_expections.index');
    }





    public function create()
    {
        $question = $this->getDefaultQuestion();

        return view('admin.date_expections.create', compact('question'));
    }



    /**
     * Store a newly created date survey question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function store(Request $request)
    {
        // Validate the incoming request data
        $this->validate($request, [
            'questions' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
        ]);

        // Create a new DateSurveyQuestion instance with the question data and store it in the database
        $question = FirstDateSurveyQuestions::create([
            'questions' => $request->input('questions'),
        ]);

        // Create options
        $optionsData = [
            $request->input('option_1'),
            $request->input('option_2'),
            $request->input('option_3'),
        ];

        foreach ($optionsData as $option) {
            // Create options in the options table and associate them with the question
            $question->options()->create([
                'option' => $option,
            ]);
        }

        // Redirect the user back to the index page with a success flash message
        return redirect('admin/date-expectations')->with('flash_message', 'DateSurveyQuestion added!');
    }





    /**
     * Show the form for editing the specified date survey question.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        // Find the date survey question by ID or throw an error if not found
        $question =  FirstDateSurveyQuestions::with('options')->findOrFail($id);
        // Return the view for editing the date survey question with the retrieved data
        return view('admin.date_expections.edit', ['question' =>  $question]);
    }

    /**
     * Update the specified date survey question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $this->validate($request, [
            'questions' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
        ]);

        // Find the date survey question by ID or throw an error if not found
        $question = FirstDateSurveyQuestions::findOrFail($id);

        // Update the question text
        $question->update([
            'questions' => $request->input('questions'),
        ]);

        // Update or create options
        $optionsData = [
            $request->input('option_1'),
            $request->input('option_2'),
            $request->input('option_3'),
        ];

        // Retrieve existing options
        $existingOptions = $question->options;

        foreach ($optionsData as $index => $option) {
            // Check if option exists
            if (isset($existingOptions[$index])) {
                // If option exists, update it
                $existingOptions[$index]->update(['option' => $option]);
            } else {
                // If option doesn't exist, create it
                FirstDateSurveyQuestionOptions::create([
                    'question_id' => $question->id,
                    'option' => $option,
                ]);
            }
        }

        // Redirect the user back to the index page with a success flash message
        return redirect('admin/date-expectations')->with('flash_message', 'DateSurveyQuestion updated!');
    }



    /**
     * Display the specified date survey question.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        try {
            // Find the date survey question by ID or throw an error if not found
            $expections = FirstDateSurveyQuestions::with('options')->findOrFail($id);

            // Return the view for showing the date survey question with the retrieved data
            return view('admin.date_expections.show', compact('expections'));
        } catch (\Exception $ex) {
            // Redirect back with an error message if the date survey question doesn't exist
            return redirect()->back()->with('error', "expections doesn't Exist!");
        }
    }

    /**
     * Remove the specified date survey question from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function destroy(Request $request, $id)
    {
        // Find the date survey question by ID
        $personaliy = DateSurveyQuestion::find($id);

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            // Attempt to delete the date survey question and return a JSON response
            if (DateSurveyQuestion::destroy($id)) {
                $data = 'Success';
            } else {
                $data = 'Failed';
            }
            return response()->json($data);
        }

        // If not an AJAX request, delete the date survey question and redirect back with a flash message
        DateSurveyQuestion::destroy($id);
        return redirect('admin/date-expectations')->with('flash_message', ' DateSurveyQuestion deleted!');
    }
    private function getDefaultQuestion()
    {
        return (object) [
            'questions' => '',
            'options' => [
                (object) ['option' => ''],
                (object) ['option' => ''],
                (object) ['option' => ''],
            ]
        ];
    }
}
