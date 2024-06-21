<?php

namespace App\Jobs;

use App\Http\Controllers\API\ApiController;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $title;
    protected $body;
    protected $targetModel;
    protected $adminId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $title, $body, $targetModel, $adminId)
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
        $this->targetModel = $targetModel;
        $this->adminId = $adminId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ApiController::pushNotifications([
            'title' => $this->title,
            'body' => $this->body,
            'data' => [
                'target_id' => $this->user->id,
                'created_by' => $this->adminId,
                'target_model' => $this->targetModel,
            ]
        ], $this->user->id, true);
    }
}
