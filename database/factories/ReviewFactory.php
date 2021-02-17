<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {



        return [
            'title' => $this->faker->sentence(),
            'review' => $this->faker->paragraph($nbSentences = rand(3, 15), $variableNbSentences = true),
            'rating' => rand(rand(1, 5), rand(7, 10)),
        ];
    }
}
