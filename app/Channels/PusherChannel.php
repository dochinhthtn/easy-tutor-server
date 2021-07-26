<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class PusherChannel {
    public function send($notifiable, Notification $notification) {
        $message = $notification->toPusher($notifiable);
        // return $message;
    }
}
