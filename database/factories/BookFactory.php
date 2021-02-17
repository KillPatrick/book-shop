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
        $title = $this->faker->sentence(rand(1,6));
        $randomDate = date("Y-m-d H:i:s", rand((time() - (10 * 24 * 60 * 60)),time()));

        return [
            'title' => $title,
            'image' => $this->faker->image('public/storage/images',480, 640, null, false, true, $title),
            'description' => $this->faker->text(500),
            'is_approved' => 1,
            'price' => (float)rand(5,30),
            'discount' => rand(0, rand(0, rand(0, 30))),
            'user_id' => rand(1, 20),
            'created_at' => $randomDate,
        ];
    }
}
