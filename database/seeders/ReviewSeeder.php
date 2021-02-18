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

        for($i = 1; $i <= 500; $i++){
            $user = User::inRandomOrder()->first();

            $userReviewBookIds = array();
            foreach($user->reviews as $review){
                $userReviewBookIds[] =  $review->book_id;
            }

            $book = Book::inRandomOrder()->whereNotIn('id', $userReviewBookIds)->first();

            Review::factory()->create(['user_id' => $user->id, 'book_id' => $book->id]);
        }
        //Review::factory()->times(100)->create();
    }
}
