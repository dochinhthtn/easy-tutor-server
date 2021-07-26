<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Pusher\PushNotifications\PushNotifications;
use App\Channels\PusherChannel;
use Illuminate\Support\Facades\Log;

class PusherNotification extends Notification implements ShouldQueue {
    use Queueable;

    // protected $instanceId;
    // protected $secretKey;
    // protected $beamClient;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return [PusherChannel::class];
    }

    public function toPusher($notifiable) {
        $instanceId = config('notification.connections.pusher.instance_id');
        $secretKey = config('notification.connections.pusher.secret_key');
        $beamClient = new PushNotifications([
            'instanceId' => $instanceId,
            'secretKey' => $secretKey
        ]);


        $interests = $this->interests($notifiable);
        $users = $this->users($notifiable);

        if (count($interests) > 0) {
            $beamClient->publishToInterests(
                $interests,
                [
                    'fcm' => $this->fcm($notifiable),
                    'apns' => $this->apns($notifiable),
                    'web' => $this->web($notifiable),
                ]
            );

            Log::info($this->notification($notifiable));
        }

        if (count($users) > 0) {
            $beamClient->publishToUsers(
                $users,
                [
                    'fcm' => $this->fcm($notifiable),
                    'apns' => $this->apns($notifiable),
                    'web' => $this->web($notifiable),
                ]
            );
        }
    }

    protected function interests($notifiable) {
        return [
            empty($notifiable->id) ? 'donuts' : 'donut-' . $notifiable->id
        ];
    }

    protected function users($notifiable) {
        return [];
    }

    protected function notification($notifiable) {
        return [];
    }

    protected function web($notifiable) {
        return ['notification' => $this->notification($notifiable)];
    }

    protected function fcm($notifiable) {
        return ['notification' => $this->notification($notifiable)];
    }

    protected function apns($notifiable) {
        return [
            'aps' => [
                'alert' => [
                    'title' => 'Hello',
                    'body' => 'This is notification from Easy Tutor'
                ]
            ]
        ];
    }
}
