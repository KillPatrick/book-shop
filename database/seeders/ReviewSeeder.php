<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $books = Book::all();
        for($i = 1; $i <= 500; $i++){
            $reviewCreated = true;
            while($reviewCreated){
                try {
                    $user = $users->find(rand(1, 20));
                    $book = $books->find(rand(1, 50));
                    Review::factory()->create(['user_id' => $user->id, 'book_id' => $book->id]);
                    $reviewCreated = false;
                } catch(\Exception $e){
                    null;
                }
            }
        }
    }
}
