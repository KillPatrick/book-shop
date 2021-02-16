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
        $book = Book::createBookWithAuthorsGenres($request->all());

        if($request->hasFile('image')){
            $book->image = $request->image->store('', ['disk' => 'my_files']);
        }

        $book->save();

        return redirect(route('user.books.index'))
                    ->with('success','Book saved, but will only be visible when approved by admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        if(!$book->is_approved){
            return redirect('/');
        }

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
        $genres = Genre::all();

        return view('book.edit', compact(['book', 'genres']));
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
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->price = $request->input('price');
        $book->discount = $request->input('discount');
        $book->genres()->sync($request['genres']);
        $book->is_approved = null;
        $authors = explode(',', $request['authors']);

        foreach($authors as $authorName){
            $author = Author::updateOrCreate(['name' => $authorName]);
            $book->authors()->sync($author->id);
        }

        if($request->hasFile('image')){
            $book->image = $request->image->store('', ['disk' => 'my_files']);
        }

        $book->save();

        return redirect(route('admin.books.index'))->with('success', 'Book saved!');
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
