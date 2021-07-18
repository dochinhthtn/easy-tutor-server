<?php

namespace App\Http\Controllers\API;

use App\Events\ConversationEvent\ConversationCreatedEvent;
use App\Events\ConversationEvent\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationRequest\AddConversationRequest;
use App\Http\Requests\ConversationRequest\AddMessageRequest;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller {
    //

    private ?User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getConversations() {
        $collection = ConversationResource::collection($this->currentUser->conversations()->with('users')->paginate(15));
        $collection->wrap('conversations');
        return $collection;
    }

    public function getConversation(Conversation $conversation) {
        if ($conversation->hasUser($this->currentUser)) {
            return new ConversationResource($conversation->load('users'));
        }

        return response()->json([
            'message' => 'You are not in this conversation'
        ], 400);
    }

    public function addConversation(AddConversationRequest $request) {
        $usersId = $request->input('users');

        if (!in_array($this->currentUser->id, $usersId)) {
            return response()->json([
                'message' => 'Some error occured :((('
            ], 400);
        }

        $result = DB::table('conversations_users')
            ->selectRaw('COUNT(conversation_id)')
            ->whereIn('user_id', $usersId)
            ->groupBy('conversation_id')
            ->get();

        $conversationCount = $result->max('COUNT(conversation_id)');
        if ($conversationCount == count($usersId)) {
            return response()->json([
                'message' => 'Conversation has already created',
            ], 400);
        }

        /**
         * @var Conversation $conversation
         */
        $conversation = Conversation::create([
            'name' => $request->input('name'),
        ]);
        $conversation->users()->attach($request->input('users'));

        $conversation->load("users");

        event(new ConversationCreatedEvent($conversation));

        return new ConversationResource($conversation);
    }

    public function addMessage(AddMessageRequest $request, Conversation $conversation) {
        // return "a";

        if (!$conversation->hasUser($this->currentUser)) {
            return response()->json([
                'message' => 'You are not in this conversation',
            ], 400);
        }

        $message = Message::create([
            'content' => $request->input('content'),
            'user_id' => $this->currentUser->id,
            'conversation_id' => $conversation->id,
        ]);
        // $msgRes = new MessageResource($message);
        // return $msgRes->conversation_id;

        event(new MessageSentEvent($message, $conversation->id));

        return response()->json([
            'message' => 'Message was sent',
        ]);
    }

    public function getMessages(Conversation $conversation) {
        if (!$conversation->hasUser($this->currentUser)) {
            return response()->json([
                'message' => 'You are not in this conversation'
            ], 400);
        }

        $collection = MessageResource::collection(
            Message::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        );

        $collection->wrap('messages');
        return $collection;
    }
}
