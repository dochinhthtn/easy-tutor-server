<?php

namespace App\Notifications\PostNotification;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Notifications\PusherNotification;
use Illuminate\Bus\Queueable;

class AcceptTutorNotification extends PusherNotification
{
    use Queueable;

    private Post $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    protected function notification($notifiable)
    {
        return [
            'title' => 'Accepted Tutor',
            'body' => "You have accepted to be a tutor at post #{$this->post->id}",
            'post' => new PostResource($this->post)
        ];
    }

}
