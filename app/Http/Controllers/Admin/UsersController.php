<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\ApiController;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\UserQuestion;
use App\Models\QuestionImage;
use App\Models\WhoViewedprofile;
use App\Models\UserLike;
use App\Models\UserBookmark;
use App\Models\UserDislike;
use App\Models\UserChat;
use App\Models\BlockUser;
use App\Models\Admin;
use App\Models\DateSurvey;
use App\Models\FirstDateSurveyQuestionOptions;
use App\Models\FirstDateSurveyQuestions;
use App\Models\Notification;
use App\Models\NotificationTranslate;
use App\Models\UserFirstDateSurveyAnswers;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void 
     */

    public function index(Request $request, $role = '')
    {
        if ($request->ajax()) {
            // Get column and direction for ordering
            $orderColumnIndex = $request->input('order.0.column');
            $orderColumnName = $request->input('columns.' . $orderColumnIndex . '.name');
            $orderDirection = $request->input('order.0.dir', 'asc');

            // Define the base query
            $query = User::select('users.id', 'users.name', 'users.email', 'users.address', 'users.is_block_by_admin', 'users.verification_status', 'users.created_at', 'user_questions.gender', 'user_questions.interested')
                ->leftJoin('user_questions', 'users.id', '=', 'user_questions.user_id')
                ->leftJoin('user_first_date_survey_answers', 'users.id', '=', 'user_first_date_survey_answers.user_id')
                ->where('users.is_verify', '=', '1');
            // ->orderBy('created_at', 'desc');

            // Apply filters if they are provided
            if ($request->has('blockFilter') && $request->input('blockFilter') !== '') {
                $blockFilter = $request->input('blockFilter');
                if ($blockFilter !== ':') {
                    $query->where('users.is_block_by_admin', $blockFilter);
                }
            }

            if ($request->has('verificationFilter') && $request->input('verificationFilter') !== '') {
                $verificationFilter = $request->input('verificationFilter');
                if ($verificationFilter !== ':') {
                    $query->where('users.verification_status', $verificationFilter);
                }
            }

            if ($request->has('genderFilter') && $request->input('genderFilter') !== '') {
                $genderFilter = $request->input('genderFilter');
                if ($genderFilter !== ':') {
                    $query->where('user_questions.gender', $genderFilter);
                }
            }

            // Apply interested filter if provided
            if ($request->has('interestedFilter') && $request->input('interestedFilter') !== '') {
                $interestedFilter = $request->input('interestedFilter');
                if ($interestedFilter !== ':') {
                    $query->where('user_questions.interested', $interestedFilter);
                }
            }


            // Apply ordering if the column name is valid and exists in the database
            if (in_array($orderColumnName, [
                'id', 'name', 'address', 'email', 'gender', 'interested', 'is_block_by_admin', 'verification_status', 'created_at'
            ])) {
                if ($orderColumnName == 'gender' || $orderColumnName == 'interested') {
                    $query->orderBy('user_questions.' . $orderColumnName, $orderDirection);
                } else {
                    $query->orderBy($orderColumnName, $orderDirection);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('gender', function ($item) {
                    return $item->gender;
                })
                ->addColumn('interested', function ($item) {
                    return $item->interested;
                })
                ->addColumn('question_answer', function ($item) {
                    $count = optional($item->userSignUpQuestion)->count() ?? 0;
                    return $this->generateButton($count > 0, "/admin/user/question_answer/{$item->id}");
                })
                ->addColumn('date_question_answer', function ($item) {
                    $count = optional($item->dateSurveys)->count() ?? 0;
                    return $this->generateButton($count > 0, "/admin/user/date_question_answer/{$item->id}");
                })
                ->addColumn('is_block_by_admin', function ($item) {
                    $isChecked = $item->is_block_by_admin == 1 ? ' checked' : '';
                    $sliderColorClass = $item->is_block_by_admin == 1 ? 'slider-red' : 'slider-gray';
                    return '<label class="switch"><input type="checkbox" class="changeStatus" value="' . $item->id . '" data-status="' . ($item->is_block_by_admin == 1 ? '0' : '1') . '"' . $isChecked . '><span class="slider ' . $sliderColorClass . ' round"></span></label>';
                })
                ->addColumn('verification_status', function ($item) {
                    $images = [
                        0 => 'late.png',
                        1 => 'wall-clock.png',
                        2 => 'verify.png',
                        3 => 'reject.png',
                    ];
                    $image = isset($images[$item->verification_status]) ? $images[$item->verification_status] : 'unknown_status.png';
                    return '<img src="' . asset('/img/' . $image) . '" alt="Status" title="Status" style="height: 20px; width: 20px;">';
                })
                ->addColumn('action', function ($item) {
                    return '<a href="' . url("/admin/users/{$item->id}") . '" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
                })
                ->addColumn('created_at', function ($item) {
                    return $item->created_at->format('d-m-Y,H:i:s');
                })
                ->rawColumns(['created_at', 'gender', 'interested', 'question_answer', 'date_question_answer', 'is_block_by_admin', 'verification_status', 'action'])
                ->make(true);
        }

        $genders = [
            0 => "Male",
            1 => "Female",
            2 => "Agender",
            3 => "Ambigender",
            4 => "Androgyne",
            5 => "Bigender",
            6 => "Butch",
            7 => "Cis female",
            8 => "Cis woman",
            9 => "Cisgender",
            10 => "Demigender",
            11 => "Gender fluidity",
            12 => "Gender neutrality",
            13 => "Gender variance",
            14 => "Intersex",
            15 => "Non-binary",
            16 => "Pangender",
            17 => "Queer",
            18 => "Trans woman",
            19 => "Transgender",
            20 => "Transsexual",
            21 => "Transsexual female",
            22 => "Trigender",
            23 => "Two-spirit"
        ];

        return view('admin.users.index', compact('role', 'genders'));
    }


    private function generateButton($exists, $url)
    {
        $button = $exists ? 'btn-info' : 'btn-info disabled';
        return '<a href="' . url($url) . '" title="View User"><button class="btn ' . $button . ' btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    // public function create()
    // {
    //     return view('admin.users.create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    // public function store(Request $request)
    // {
    //     $this->validate(
    //         $request,
    //         [
    //             'email' => 'required|string|max:255|email|unique:users',
    //             'password' => 'required',
    //         ]
    //     );
    //     $data = $request->except('password', 'profile_image', 'is_verify');
    //     // if (!empty($request->profile_image)) {
    //     //     $data['profile_image'] =parent::__uploadImage($request->file('profile_image'), public_path(user::$_imagePublicPath));
    //     //    }
    //     $data['password'] = bcrypt($request->password);
    //     $data['is_verify'] = "1";
    //     $user = User::create($data);
    //     return redirect('admin/user/list')->with('flash_message', 'User added!');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $userQuestion = UserQuestion::where('user_id', $user->id)->first();
            if ($userQuestion == null) {
                $prifile_images = null;
            } else {
                $prifile_images = QuestionImage::where('user_id', $id)->where('question_id', $userQuestion->id)->first();
            }
            // dd($prifile_images);
            return view('admin.users.show', compact('user', 'prifile_images'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "User doesn't Exist!");
        }
    }
    public function question_answer($id)
    {

        try {
            $user = UserQuestion::where('user_id', $id)->first();
            $user_images = QuestionImage::where('user_id', $id)->where('question_id', $user->id)->get();
            // dd($user_images);
            return view('admin.users.question_answer', compact('user', 'user_images'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "User doesn't Exist!");
        }
    }
    public function date_question_answer($id)
    {
        try {
            // Retrieve the user's survey answers
            $userAnswers = UserFirstDateSurveyAnswers::where('user_id', $id)->firstOrFail();

            // Define arrays to store question and option texts
            $questions = [];
            $options = [];

            // Loop through each answer and fetch details
            for ($i = 1; $i <= 9; $i++) {
                $answerKey = "answer_$i";
                $answerData = $this->getAnswerData($userAnswers->$answerKey);

                if ($answerData) {
                    $questions[] = $answerData['question'];
                    $options[] = $answerData['option'];
                } else {
                    $questions[] = 'N/A';
                    $options[] = 'N/A';
                }
            }

            // Pass the arrays to the view
            return view('admin.users.date_question_answer', compact('questions', 'options'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "User doesn't Exist!");
        }
    }

    private function getAnswerData($answerJson)
    {
        // Decode the JSON string
        $answerArray = json_decode($answerJson, true);

        // If decoding is successful and the keys exist, fetch the question and option texts
        if ($answerArray && isset($answerArray['question_id']) && isset($answerArray['option_id'])) {
            $question = FirstDateSurveyQuestions::find($answerArray['question_id']);
            $option = FirstDateSurveyQuestionOptions::find($answerArray['option_id']);

            return [
                'question' => $question ? $question->questions : 'N/A',
                'option' => $option ? $option->option : 'N/A',
            ];
        }

        return null;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    // public function edit($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);
    //         return view('admin.users.edit', compact('user'));
    //     } catch (\Exception $ex) {
    //         return redirect()->back()->with('error', "User doesn't Exist!");
    //     }
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    // public function update(Request $request, $id)
    // {
    //     $this->validate(
    //         $request,
    //         [
    //             'email' => 'required|string|max:255|email|unique:users,email,' . $id,
    //             // 'roles' => 'required'
    //         ]
    //     );
    //     $data = $request->except('password', 'profile_image');
    //     $data['password'] = bcrypt($request->password);
    //     // if (!empty($request->profile_image)) {
    //     //     $data['profile_image'] =parent::__uploadImage($request->file('profile_image'), public_path(user::$_imagePublicPath));
    //     //    }
    //     $user = User::findOrFail($id);
    //     $user->update($data);
    //     return redirect('admin/user/list')->with('flash_message', 'User updated!');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        BlockUser::where('blocked_by', $id)->delete();
        BlockUser::where('blocked_user', $id)->delete();
        UserQuestion::where('user_id', $id)->delete();
        WhoViewedprofile::where('view_by', $id)->delete();
        UserLike::where('like_by', $id)->delete();
        UserBookmark::where('bookmark_by', $id)->delete();
        UserDislike::where('dislike_by', $id)->delete();
        WhoViewedprofile::where('view_user', $id)->delete();
        UserLike::where('like_user', $id)->delete();
        UserBookmark::where('bookmark_user', $id)->delete();
        UserDislike::where('dislike_user', $id)->delete();
        // UserChat::where('sender_id', $id)->orWhere('receiver_id', $id)->delete();
        Notification::whereRaw('JSON_UNQUOTE(JSON_EXTRACT(message, "$.target_id")) = ?', [$id])
            ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(message, "$.created_by")) = ?', [$id])
            ->delete();
        if ($request->ajax()) {
            if (User::destroy($id)) {
                $data = 'Success';
            } else {
                $data = 'Failed';
            }
            return response()->json($data);
        }
        User::destroy($id);
        return redirect('admin/user/list')->with('flash_message', ' User deleted!');
    }


    public function changeStatus(Request $request)
    {

        $user = User::find($request->id);

        if (!$user) {
            return response()->json(["success" => false, 'message' => 'User not found!']);
        }

        $oldVerificationStatus = $user->verification_status;
        $newVerificationStatus = $request->status;
        // dd($newVerificationStatus);

        $user->update(['verification_status' => $newVerificationStatus]);

        // Notification about verification status change
        $notificationTitle = 'Verification Status Change';
        $notificationBody = "Your verification status has been changed from {$oldVerificationStatus} to {$newVerificationStatus}.";
        $targetModel = 'verification_status_change';

        if ($newVerificationStatus == 3) {
            // If verification status is rejected (status code 2)
            $targetModel = 'image_rejected';
        } elseif ($newVerificationStatus == 2) {
            // If verification status is verified (status code 1)
            $targetModel = 'image_verified';
        }
        $userLanguage =  $user->language;
        $notificationType = $targetModel;
        $titleColumn = "title_" . $userLanguage;
        $bodyColumn = "body_" . $userLanguage;
        $userTranslatedNotification = NotificationTranslate::where('notification_type', $notificationType)->first();
        $title = $userTranslatedNotification->$titleColumn;
        $body = $userTranslatedNotification->$bodyColumn;

        // Get the admin ID using the Admin model method
        $adminId = Admin::getAuthenticatedAdminId();
        // dd($adminId);

        if ($adminId !== null) {
            // Send the notification
            ApiController::pushNotifications([
                'title' => $title,
                'body' => $body,
                'data' => [
                    'target_id' => $user->id,
                    'created_by' => $adminId,
                    'target_model' => $targetModel,
                ]
            ], $user->id, true);
            return response()->json(["success" => true, 'message' => 'User updated successfully']);
        } else {
            return response()->json(["success" => false, 'message' => 'Admin not authenticated']);
        }
    }
    public function updateStatus(Request $request)
    {
        $userId = $request->id;
        $newStatus = $request->is_block_by_admin;

        // Update user status
        User::where('id', $userId)->update(['is_block_by_admin' => $newStatus]);
        if ($newStatus == 1) {
            $tokens = Token::where('user_id', $userId)->get();
            // dd($tokens);

            foreach ($tokens as $token) {
                $token->forceDelete();
            }
        }


        return response()->json(["success" => true, 'message' => 'Status updated!']);
    }

    public function create()
    {
        return view('admin.push_notifications.create');
    }

    // public function store(Request $request)
    // {
    //     $title = $request->input('title');
    //     $body = $request->input('body');
    //     $targetModel = $request->input('target_model', 'admin_notifications');
    //     // dd($targetModel);

    //     $this->sendNotificationsToAllUsers($title, $body, $targetModel);

    //     return redirect('admin/notification/form')->with('flash_message', 'Personality added!');
    // }

    // private function sendNotificationsToAllUsers($title, $body, $targetModel)
    // {
    //     $adminId = Admin::getAuthenticatedAdminId();

    //     if ($adminId !== null) {
    //         $users = User::all();

    //         foreach ($users as $user) {
    //             $this->sendNotificationToUser($user, $title, $body, $targetModel, $adminId);
    //         }
    //     }
    // }

    // private function sendNotificationToUser($user, $title, $body, $targetModel, $adminId)
    // {
    //     ApiController::pushNotifications([
    //         'title' => $title,
    //         'body' => $body,
    //         'data' => [
    //             'target_id' => $user->id,
    //             'created_by' => $adminId,
    //             'target_model' => $targetModel,
    //         ]
    //     ], $user->id, true);
    // }
    public function store(Request $request)
    {
        $title = $request->input('title');
        $body = $request->input('body');
        $targetModel = $request->input('target_model', 'admin_notifications');

        $this->sendNotificationsToAllUsers($title, $body, $targetModel);

        return redirect('admin/notification/form')->with('flash_message', 'Notification added!');
    }

    private function sendNotificationsToAllUsers($title, $body, $targetModel)
    {
        $adminId = Admin::getAuthenticatedAdminId();

        if ($adminId !== null) {
            $users = User::all();

            foreach ($users as $user) {
                SendNotificationJob::dispatch($user, $title, $body, $targetModel, $adminId);
            }
        }
    }
}
