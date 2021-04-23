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

    private  ? User $currentUser;

    public function __construct() {
        $this->currentUser = auth()->user();
    }

    public function getConversations() {
        return ConversationResource::collection($this->currentUser->conversations()->paginate(15));
    }

    public function getConversation(Conversation $conversation) {
        return new ConversationResource($conversation->load('messages', 'users'));
    }

    public function addConversation(AddConversationRequest $request) {
        $result = DB::table('conversations_users')
            ->selectRaw('COUNT(conversation_id) AS conversationCount')
            ->whereIn('user_id', $request->input('users'))
            ->groupBy('conversation_id')
            ->orderBy('conversationCount', 'desc')
            ->limit(1)
            ->get();

        $conversationCount = $result->pluck('conversationCount')->first();
        if($conversationCount == count($request->input('users'))) {
            return response()->json([
                'message' => 'Conversation has already created'
            ], 400);
        }

        /**
         * @var Conversation $conversation
         */
        $conversation = Conversation::create([
            'name' => $request->input('name'),
        ]);
        $conversation->users()->attach($request->input('users'));

        event(new ConversationCreatedEvent($conversation));

        return response()->json([
            'message' => 'Create conversation successfully',
            'conversation' => $conversation
        ]);
    }

    public function addMessage(AddMessageRequest $request, Conversation $conversation) {
        $exist = $conversation->users()->wherePivot('user_id', '=', $this->currentUser->id)->count();
        
        if($exist == 0) {
            return response()->json([
                'message' => 'You are not in this conversation'
            ], 400);
        }

        $message = Message::create([
            'content' => $request->input('content'),
            'user_id' => $this->currentUser->id,
            'conversation_id' => $conversation->id
        ]);

        event(new MessageSentEvent($message));
        
        return response()->json([
            'message' => 'Message was sent'
        ]);
    }

    public function getMessages($conversationId) {
        $query = Message::where('conversation_id', $conversationId)->orderBy('created_at', 'desc')->paginate(15);
        return MessageResource::collection($query);
    }
}
