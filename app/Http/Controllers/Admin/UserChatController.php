<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserChat as MyModel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserChatController extends Controller
{


    // public function index(Request $request)
    // {
    //     // Select the latest chat for each combination of receiver_id and sender_id
    //     $sub = MyModel::select('receiver_id', 'sender_id', DB::raw('MAX(created_at) as max_date'))
    //         ->where('receiver_id', '!=', 0)
    //         ->groupBy(['receiver_id', 'sender_id']);

    //     // Join with the original table to get the full chat details for the latest chats
    //     $model = MyModel::joinSub($sub, 'latest_chats', function ($join) {
    //         $join->on('user_chats.receiver_id', '=', 'latest_chats.receiver_id')
    //             ->on('user_chats.sender_id', '=', 'latest_chats.sender_id')
    //             ->on('user_chats.created_at', '=', 'latest_chats.max_date');
    //     })
    //         ->select('user_chats.*');

    //     // Filter out rows where receiver_id and sender_id are not unique combinations
    //     $model = $model->where('user_chats.receiver_id', '!=', 0);

    //     $dataSend = [];
    //     $dataSend['data'] = [];

    //     $uniquePairs = [];

    //     foreach ($model->get() as $data) {
    //         $receiverId = $data->receiver_id;
    //         $senderId = $data->sender_id;

    //         // Check if the combination of receiver_id and sender_id is already added
    //         if (!isset($uniquePairs[$receiverId][$senderId]) && !isset($uniquePairs[$senderId][$receiverId])) {
    //             // Add the chat data to the result
    //             $dataSend['data'][] = $data;

    //             // Mark the combination as added
    //             $uniquePairs[$receiverId][$senderId] = true;
    //         }
    //     }

    //     return view('admin.user_chats.index', compact('dataSend'));
    // }
    public function index(Request $request)
    {
        // Select the latest chat for each combination of receiver_id and sender_id
        $sub = MyModel::select('receiver_id', 'sender_id', DB::raw('MAX(created_at) as max_date'))
            ->where('receiver_id', '!=', 0)
            ->groupBy(['receiver_id', 'sender_id']);

        // Join with the original table to get the full chat details for the latest chats
        $model = MyModel::joinSub($sub, 'latest_chats', function ($join) {
            $join->on('user_chats.receiver_id', '=', 'latest_chats.receiver_id')
                ->on('user_chats.sender_id', '=', 'latest_chats.sender_id')
                ->on('user_chats.created_at', '=', 'latest_chats.max_date');
        })
            ->select('user_chats.*');

        // Filter out rows where receiver_id and sender_id are not unique combinations
        $model = $model->where('user_chats.receiver_id', '!=', 0);

        $dataSend = [];
        $dataSend['data'] = [];

        $uniquePairs = [];

        foreach ($model->get() as $data) {
            $receiverId = $data->receiver_id;
            $senderId = $data->sender_id;

            // Check if both receiver and sender exist
            $receiver = User::find($receiverId);
            $sender = User::find($senderId);

            if (!$receiver || !$sender) {
                continue; // Skip adding chat data if either receiver or sender doesn't exist
            }

            // Check if the combination of receiver_id and sender_id is already added
            if (!isset($uniquePairs[$receiverId][$senderId]) && !isset($uniquePairs[$senderId][$receiverId])) {
                // Add the chat data to the result
                $dataSend['data'][] = $data;

                // Mark the combination as added
                $uniquePairs[$receiverId][$senderId] = true;
            }
        }

        return view('admin.user_chats.index', compact('dataSend'));
    }



    public function inBetweenChats(Request $request, $receiver_id, $sender_id)
    {
        // Construct the query to fetch chat messages between the provided receiver and sender
        $chats = MyModel::where(function ($query) use ($receiver_id, $sender_id) {
            $query->where('sender_id', $sender_id)
                ->where('receiver_id', $receiver_id);
        })->orWhere(function ($query) use ($receiver_id, $sender_id) {
            $query->where('sender_id', $receiver_id)
                ->where('receiver_id', $sender_id);
        })->orderBy('created_at', 'asc') // Order by ascending to show oldest messages first
            ->paginate(1000000); // Adjust the pagination limit as needed

        // Get details of the receiver user
        $receiver_detail = User::find($receiver_id);
        // Get details of the sender user
        $sender_detail = User::find($sender_id);


        // Pass the necessary data to the view
        return view('admin.user_chats.show', compact('receiver_detail', 'chats', 'sender_detail'));
    }
}
