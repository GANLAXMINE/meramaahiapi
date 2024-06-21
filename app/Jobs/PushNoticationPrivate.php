<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNoticationPrivate implements ShouldQueue {

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
       $userChatData = \App\Models\UserChat::whereId($this->idd)->first();
       \App\Http\Controllers\API\ApiController::pushNotifications(['title' => 'Message from ' . $userChatData->sender_name, 'body' => $userChatData->message], $userChatData->receiver_id, ['target_id' => $userChatData->sender_id, 'target_type' => 'Chat', 'target_name' => $userChatData->sender_name]);
    }

}
