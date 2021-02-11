<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class GenreBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::all()->each(function ($book)
        {
            Genre::all()->random(rand(1, rand(1, 3)))->each(function ($genre) use ($book)
            {
                $book->genres()->attach($genre->id);
            });
        });

    }
}
