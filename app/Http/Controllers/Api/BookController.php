<?php

namespace App\Http\Controllers\Api;

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

    public function show(Request $request)
    {
        $book = Book::findOrFail($request->id);

        return new BookResource($book);
    }
}
