<?php

namespace App\Models;

use App\Models\User;
use App\Models\QuestionImage;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserChat extends Model
{

    use LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_chats';
    protected $charset = 'utf8mb4';
    protected $collation = 'utf8mb4_unicode_ci';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    public static $_imagePublicPath = 'uploads/users/chats';
    protected $fillable = ['local_message_id', 'message_id', 'reply_id', 'sender_id', 'receiver_id', 'attachment', 'message', 'type', 'details', 'params', 'is_read', 'is_chat_enabled', 'match_notify'];
    public static $__rulesSelect = ['id', 'local_message_id', 'message_id', 'reply_id', 'sender_id', 'receiver_id', 'attachment', 'message', 'type', 'is_read', 'created_at'];
    protected $hidden = ['details', 'state', 'params'];

    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }

    protected $appends = array('sender_name', 'sender_image', 'sender_tumbnail_image', 'receiver_name', 'receiver_image', 'receiver_tumbnail_image', 'reply_count', 'error', 'error_message', 'sender_is_blocked', 'receiver_is_blocked');

    public function getReplyCountAttribute()
    {
        try {
            $model = UserChat::where('reply_id', $this->id)->get();
            if ($model->isEmpty() !== true)
                return $model->count();
            return 0;
        } catch (\Exception $ex) {
            return 0;
        }
    }


    public function getErrorAttribute()
    {
        return false;
    }

    public function getErrorMessageAttribute()
    {
        return null;
    }

    // public function getSenderNameAttribute()
    // {
    //     try {
    //         $model = User::where('id', $this->sender_id)->get();
    //         if ($model->isEmpty() !== true)
    //             return $model->first()->name;
    //         return null;
    //     } catch (\Exception $ex) {
    //         return null;
    //     }
    // }
    public function getSenderNameAttribute()
    {
        try {
            $receiverUser = User::find($this->sender_id);

            // Check if the receiver user exists and is deactivated
            if ($receiverUser && $receiverUser->is_deactivate == 1) {
                return 'Hito User';
            }
            $model = User::where('id', $this->sender_id)->get();
            return $model->isEmpty() ? "Hito User" : $model->first()->name;
        } catch (\Exception $ex) {
            return null;
        }
    }



    public function getSenderImageAttribute()
    {
        try {
            $model = QuestionImage::where('user_id', $this->sender_id)->get();
            if ($model->isEmpty() !== true)
                return  $model->first()->image;
            return null;
        } catch (\Exception $ex) {
            return null;
        }
    }


    public function getSenderTumbnailImageAttribute()
    {
        try {
            $receiverUser = User::find($this->sender_id);

            // Check if the receiver user exists and is deactivated
            if ($receiverUser && $receiverUser->is_deactivate == 1) {
                return 'https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png';
            }
            $senderImages = QuestionImage::where('user_id', $this->sender_id)->get();

            if ($senderImages->isNotEmpty()) {
                // Assuming you want to get the thumbnail of the first image for the sender
                $firstImage = $senderImages->first();
                $thumbImage = $firstImage->thumb_image;

                return $thumbImage;
            }

            return 'https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png';
        } catch (\Exception $ex) {
            return null;
        }
    }


    // public function getReceiverNameAttribute()
    // {
    //     try {
    //         if ($this->receiver_id == '0' || $this->receiver_id == null || $this->receiver_id == '')
    //             return null;
    //         $model = User::where('id', $this->receiver_id)->get();
    //         if ($model->isEmpty() !== true)
    //             return $model->first()->name;
    //         return null;
    //     } catch (\Exception $ex) {
    //         return null;
    //     }
    // }

    public function getReceiverNameAttribute()
    {
        try {
            $receiverUser = User::find($this->receiver_id);

            // Check if the receiver user exists and is deactivated
            if ($receiverUser && $receiverUser->is_deactivate == 1) {
                return 'Hito User';
            }
            if ($this->receiver_id == '0' || $this->receiver_id == null || $this->receiver_id == '')
                return null;

            $model = User::where('id', $this->receiver_id)->get();

            return $model->isEmpty() ? "Hito User" : $model->first()->name;
        } catch (\Exception $ex) {
            return null;
        }
    }


    public function getReceiverImageAttribute()
    {
        try {
            if ($this->receiver_id == '0' || $this->receiver_id == null || $this->receiver_id == '')
                return null;
            $model = QuestionImage::where('user_id', $this->receiver_id)->get();
            if ($model->isEmpty() !== true)
                return  $model->first()->image;
            return null;
        } catch (\Exception $ex) {
            return null;
        }
    }
    public function getReceiverTumbnailImageAttribute()
    {
        try {
            $receiverUser = User::find($this->receiver_id);

            // Check if the receiver user exists and is deactivated
            if ($receiverUser && $receiverUser->is_deactivate == 1) {
                return 'https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png';
            }
            if ($this->receiver_id == '0' || $this->receiver_id == null || $this->receiver_id == '') {
                return null;
            }

            $model = QuestionImage::where('user_id', $this->receiver_id)->get();

            if (!$model->isEmpty()) {
                $firstImage = $model->first();
                $thumbImage = $firstImage->thumb_image;
                // dd(explode("images/",$model->first()->image)[1],$thumb_image);
                return $thumbImage;
            }

            // If $model is empty, return null
            return 'https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png';
        } catch (\Exception $ex) {
            // Handle the exception if necessary
            return null;
        }
    }
    // public function getReceiverTumbnailImageAttribute()
    // {
    //     try {
    //         if ($this->receiver_id == '0' || $this->receiver_id == null || $this->receiver_id == '') {
    //             return null;
    //         }

    //         $model = QuestionImage::where('user_id', $this->receiver_id)->get();

    //         if (!$model->isEmpty()) {
    //             $firstImage = $model->first();
    //             $thumbImage = $firstImage->thumb_image;
    //             return $thumbImage;
    //         }

    //         // If $model is empty, return the default avatar image URL
    //         return 'https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png';
    //     } catch (\Exception $ex) {
    //         // Handle the exception if necessary
    //         return null;
    //     }
    // }


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function getReceiverIsBlockedAttribute()
    {
        try {
            $receiverIsBlocked = \App\Models\BlockUser::where('blocked_by', $this->receiver_id)
                ->where('blocked_user', $this->sender_id)
                ->exists();


            return $receiverIsBlocked ? 1 : 0; // Return 1 if blocked, 0 if not blocked
        } catch (\Exception $ex) {
            return null;
        }
    }
    public function getSenderIsBlockedAttribute()
    {
        try {
            $senderIsBlocked = \App\Models\BlockUser::where('blocked_by', $this->sender_id)
                ->where('blocked_user', $this->receiver_id)
                ->exists();


            return $senderIsBlocked ? 1 : 0; // Return 1 if blocked, 0 if not blocked
        } catch (\Exception $ex) {
            return null;
        }
    }
}
