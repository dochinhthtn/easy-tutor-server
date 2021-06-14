<?php

namespace App\Events\ConversationEvent;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public  ? MessageResource $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message) {
        //
        $this->message = new MessageResource($message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastAs() {
        return 'new-message';
    }
}
