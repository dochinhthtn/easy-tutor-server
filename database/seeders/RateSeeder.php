<?php

namespace Database\Seeders;

use App\Models\Rate;
use App\Models\User;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role_id', 3)->get();
        $tutors = User::where('role_id', 2)->get();

        Rate::factory()->count(40)->state(function (array $attributes) use ($users, $tutors) {
            return [
                'assessor_id' => $users->random()->id,
                'tutor_id' => $tutors->random()->id
            ];
        })->create();
    }
}
