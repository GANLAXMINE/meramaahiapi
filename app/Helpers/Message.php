<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Message
{
    public static function getLocalizedMessage($messageType, $userLanguage)
    {
        $languageColumn = 'message_' . $userLanguage;

        // Fetch the message from toast_messages table
        $message = DB::table('toast_messages')
            ->where('message_type', $messageType)
            ->value($languageColumn);

        if (!$message) {
            // Fallback to English if the message is not found in user's preferred language
            $message = DB::table('toast_messages')
                ->where('message_type', $messageType)
                ->value('message_en');
        }

        return $message;
    }
}
