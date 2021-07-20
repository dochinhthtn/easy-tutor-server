<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $subjects = Subject::all();
        User::factory()->count(20)->create()->each(function(User $user) use ($subjects) {
            $user->subjects()->saveMany($subjects->random(3));
        });
    }
}
