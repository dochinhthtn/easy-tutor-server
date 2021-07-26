<?php

namespace App\Notifications\PostNotification;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PusherNotification;

class NewApplicantNotification extends PusherNotification {

    private Post $post;
    private User $applicant;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $applicant) {
        $this->post = $post;
        $this->applicant = $applicant;
    }

    protected function notification($notifiable)
    {
        return [
            'title' => 'New Applicant',
            'body' => "{$this->applicant->name} applied post #{$this->post->id}",
            'post' => new PostResource($this->post)
        ];
    }

}
