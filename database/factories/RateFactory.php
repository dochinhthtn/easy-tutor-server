<?php

namespace Database\Factories;

use App\Models\Rate;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'assessor_id' => 1,
            'tutor_id' => 1,
            'star' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence
        ];
    }
}
