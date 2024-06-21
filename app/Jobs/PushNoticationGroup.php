<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNoticationGroup implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id) {
        //
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() 
    {
    //    $userChatData = \App\Models\UserChat::where('id', $this->id)->first();
    //    $sender_ids = \App\Models\UserChat::where('reply_id', $userChatData->reply_id)->get()->pluck('sender_id')->toArray();
    //    $sender_ids = array_unique($sender_ids);
    //    $sender_ids = array_merge($sender_ids, [\App\UserChat::where('id', $userChatData->reply_id)->first()->sender_id]);
    //    $sender_ids = array_merge($sender_ids, [$userChatData->sender_id]);
    //    if (array_search($userChatData->sender_id, $sender_ids) !== false)
    //        unset($sender_ids[array_search($userChatData->sender_id, $sender_ids)]);
    //    foreach (array_unique($sender_ids) as $sender_id):
    //        \App\Http\Controllers\API\ApiController::pushNotifications(['title' => 'Message from ' . $userChatData->sender_name, 'body' => $userChatData->message], $sender_id, ['target_id' => $userChatData->reply_id, 'target_type' => 'Reply']);
    //    endforeach;
    }

}
