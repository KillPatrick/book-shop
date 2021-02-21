<?php

namespace App\Http\Controllers\Guest;

use App\Models\Book;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::whereNotNull('is_approved')
                    ->with('authors')
                    ->with('genres')
                    ->withAvg('reviews', 'rating')
                    ->when(request('search'), function ($query) {
                        $search = request('search');
                        $query->whereNotNull('is_approved')
                            ->where('title', 'LIKE', '%' . $search . '%')
                            ->orWhere(function($query) use ($search){
                               $query->whereNotNull('is_approved')
                                   ->where('description', 'LIKE', '%' . $search . '%');
                            })
                            ->orWhereHas('genres', function ($query) use ($search) {
                                $query->whereNotNull('is_approved')
                                        ->where('name', 'LIKE', '%' . $search . '%');
                            })
                            ->orWhereHas('authors', function ($query) use ($search) {
                                $query->whereNotNull('is_approved')
                                      ->where('name', 'LIKE', '%' . $search . '%');
                            });
                    })
                    ->latest()
                    ->paginate(25);

        return view('book.index', compact('books'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }
}
