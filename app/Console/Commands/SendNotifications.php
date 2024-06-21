<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserChat;
use App\Models\UserMatch;
use App\Http\Controllers\API\ApiController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendNotifications extends Command
{
    protected $signature = 'notifications:send-delayed';

    protected $description = 'Send delayed notifications to matched users with UserChat records';

    // public function handle()
    // {
    //     $authUserId = auth()->id();

    //     $uniqueReceiverIds = UserChat::where('sender_id', $authUserId)->distinct()->pluck('receiver_id');
    //     $fiveDaysAgo = Carbon::now()->subDays(5);

    //     foreach ($uniqueReceiverIds as $receiverId) {
    //         $userChat = UserChat::where('sender_id', $authUserId)
    //             ->where('receiver_id', $receiverId)
    //             ->where('created_at', '>=', $fiveDaysAgo)
    //             ->latest()
    //             ->first();
    //         if ($userChat && $this->isMatch($userChat)) {
    //             $title = 'Ghost Thermometer';
    //             $body = 'Could you kindly furnish us with the responses pertaining to the Ghost Thermometer';
    //             $data = [
    //                 'target_id' => $userChat->receiver_id,
    //                 'created_by' => $userChat->sender_id,
    //                 'target_model' => 'user_notifications',
    //             ];
    //             try {
    //                 ApiController::$_AuthId = $userChat->sender_id;
    //                 ApiController::pushNotifications(['title' => $title, 'body' => $body, 'data' => $data], $userChat->receiver_id, true);
    //                 Log::info("Push notification sent successfully for matched UserChat with ID {$userChat->id}");
    //             } catch (\Exception $e) {
    //                 Log::error("Error sending push notification for UserChat with ID {$userChat->id}: {$e->getMessage()}");
    //             }
    //         }
    //     }

    //     $this->info('Notifications sent successfully.');
    // }
    public function handle()
    {
        $uniqueReceiverIds = UserChat::distinct('receiver_id')->pluck('receiver_id');
        // $fiveDaysAgo = now()->subDays(5);

        foreach ($uniqueReceiverIds as $receiverId) {
            $userChat = UserChat::where('receiver_id', $receiverId)
                ->latest()
                ->first();

            if ($userChat && $this->isMatch($userChat)) {
                $title = 'Ghost Thermometer';
                $body = 'Could you kindly furnish us with the responses pertaining to the Ghost Thermometer';
                $data = [
                    'target_id' => $userChat->receiver_id,
                    'created_by' => $userChat->sender_id,
                    'target_model' => 'user_notifications',
                ];

                try {
                    ApiController::$_AuthId = $userChat->sender_id;
                    ApiController::pushNotifications(['title' => $title, 'body' => $body, 'data' => $data], $userChat->receiver_id, true);
                    Log::info("Push notification sent successfully for matched UserChat with ID {$userChat->id}");
                } catch (\Exception $e) {
                    Log::error("Error sending push notification for UserChat with ID {$userChat->id}: {$e->getMessage()}");
                }
            }
        }

        $this->info('Notifications sent successfully.');
    }
    // public function handle()
    // {
    //     $fiveDaysAgo = now()->subDays(5);

    //     // Get all UserChats created exactly five days ago
    //     $userChats = UserChat::whereDate('created_at', $fiveDaysAgo->toDateString())->get();

    //     foreach ($userChats as $userChat) {
    //         // Check if the users are matched
    //         if ($this->isMatch($userChat)) {
    //             $title = 'Ghost Thermometer';
    //             $body = 'Could you kindly furnish us with the responses pertaining to the Ghost Thermometer';
    //             $data = [
    //                 'target_id' => $userChat->receiver_id,
    //                 'created_by' => $userChat->sender_id,
    //                 'target_model' => 'user_notifications',
    //             ];

    //             try {
    //                 ApiController::$_AuthId = $userChat->sender_id;
    //                 ApiController::pushNotifications(['title' => $title, 'body' => $body, 'data' => $data], $userChat->receiver_id, true);
    //                 Log::info("Push notification sent successfully for matched UserChat with ID {$userChat->id}");
    //             } catch (\Exception $e) {
    //                 Log::error("Error sending push notification for UserChat with ID {$userChat->id}: {$e->getMessage()}");
    //             }
    //         }
    //     }

    //     $this->info('Notifications sent successfully.');
    // }




    private function isMatch($userChat)
    {
        // Check if the users are matched
        return UserMatch::where(function ($query) use ($userChat) {
            $query->where(function ($subquery) use ($userChat) {
                $subquery->where('user_id', $userChat->sender_id)
                    ->where('match_user', $userChat->receiver_id);
            })->orWhere(function ($subquery) use ($userChat) {
                $subquery->where('user_id', $userChat->receiver_id)
                    ->where('match_user', $userChat->sender_id);
            });
        })->exists();
    }
}
