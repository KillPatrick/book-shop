<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::all()->each(function ($book) {
            User::all()->random(rand(1, 11))->each(function ($user) use ($book){
                Rating::create([
                    'rating' => rand(3, 10),
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                ]);
            });
        });

    }
}
