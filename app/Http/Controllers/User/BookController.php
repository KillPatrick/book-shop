<?php

namespace App\Http\Controllers\User;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use Illuminate\Http\Request;
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
        $books = Book::with('authors')
                    ->with('genres')
                    ->when(request('search'), function ($query) {
                        $search = request('search');
                        $query->where('title', 'LIKE', '%'.$search.'%')
                            ->orWhere('description', 'LIKE', '%'.$search.'%')
                            ->orWhereHas('genres', function ($query) use ($search){
                                $query->where('name', 'LIKE', '%'.$search.'%');
                            })->orWhereHas('authors', function ($query) use ($search) {
                                $query->where('name', 'LIKE', '%'.$search.'%');
                            });
                    })
                    ->latest()
                    ->whereNotNull('is_approved')
                    ->paginate(25);

        return view('book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('book.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = auth()->user()->books()->create($request->all());
        $book->genres()->attach($request->input('genres'));
        $authors = explode(',', $request->input('authors'));
        foreach($authors as $authorName){
            $author = Author::updateOrCreate(['name' => $authorName]);
            $book->authors()->attach($author->id);
        }

        $book->save();

        return redirect(route('user.books.index'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
