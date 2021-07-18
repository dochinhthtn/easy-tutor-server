<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $users = User::all();

        Post::factory()
            ->count(10)
            ->has(
                Comment::factory()
                    ->count(10)
                    ->state(function (array $attributes) use ($users) {
                        return ['user_id' => $users->random()->id];
                    })
            )
            ->create();
    }
}
