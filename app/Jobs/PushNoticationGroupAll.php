<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNoticationGroupAll implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $idd;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id) {
        //
        $this->idd = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $userIds = \App\Models\User::usersIdByPermissionName('Group Chat');
        // $userChatData = \App\Models\UserChat::where('id', $this->idd)->get()->first();
        // if (isset($userChatData->sender_id))
        //     unset($userIds[array_search($userChatData->sender_id, $userIds)]);
        // \App\Http\Controllers\API\ApiController::pushNotificationiOSMultipleUsers(['title' => 'Group Message From ' . $userChatData->sender_name, 'body' => $userChatData->message], $userIds, ['target_id' => $this->idd, 'target_type' => 'Reply']);
    }

}
