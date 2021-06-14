<?php

namespace App\Events\PostEvent;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewApplicantEvent implements ShouldBroadcastNow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  ? PostResource $post;
    public  ? UserResource $applicant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PostResource $post, UserResource $applicant) {
        $this->post = $post;
        $this->applicant = $applicant;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('post.' . $this->post->id);
    }

    public function broadcastAs() {
        return "new-applicant";
    }
}
