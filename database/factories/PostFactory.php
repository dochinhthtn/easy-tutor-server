<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::where('role_id', 3)->get()->random(1)->first();
        $subject = Subject::all()->random(1)->first();

        return [
            'user_id' => $user->id,
            'subject_id' => $subject->id,
            'description' => $this->faker->text,
            'address' => $this->faker->address,
            'offer' => $this->faker->numberBetween(10, 5000),
            'tutor_id' => null,
            'grade' => $this->faker->numberBetween(6, 12)
        ];
    }
}
