<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorBookSeeder extends Seeder
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
            Author::all()->random(rand(1, rand(1, 2)))->each(function ($author) use ($book)
            {
                $book->authors()->attach($author->id);
            });
        });
    }
}
