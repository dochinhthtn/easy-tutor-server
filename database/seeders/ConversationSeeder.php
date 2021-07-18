<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        Conversation::factory()->count(10)->create()->each(function(Conversation $conversation) use ($users){
            $memberIds = array_rand($users->pluck('id')->toArray(), 2);
            $conversation->users()->attach($memberIds);

            Message::factory()->count(10)->create([
                'conversation_id' => $conversation->id,
                'user_id' => array_rand($memberIds, 1)
            ]);
        });
    }
}
