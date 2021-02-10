<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(rand(1,6)),
            'image' => $this->faker->imageUrl(480, 640),
            'description' => $this->faker->text(500),
            'is_approved' => 1,
            'created_by' => rand(1, 20),
        ];
    }
}
