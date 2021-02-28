<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('genres')
                ->with('authors')
                ->whereNotNull('is_approved')->get();

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        if($book->is_approved){
            return new BookResource($book);
        }

        abort(404);
    }
}
