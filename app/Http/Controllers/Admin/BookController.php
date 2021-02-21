<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreBookRequest;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Author;
use App\Services\ImageService;
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
                    ->withAvg('reviews', 'rating')
                    ->when(request('search'), function ($query) {
                        $search = request('search');
                        $query->where('title', 'LIKE', '%'.$search.'%')
                            ->orWhere('description', 'LIKE', '%'.$search.'%')
                            ->orWhereHas('genres', function ($query) use ($search){
                                $query->where('name', 'LIKE', $search);
                            })->orWhereHas('authors', function ($query) use ($search) {
                                $query->where('name', 'LIKE', $search);
                            });
                    })
                    ->when(request('not_approved'), function ($query) {
                        $query->whereNull('is_approved');
                    })
                    ->when(request('user_books'), function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    })
                    ->latest()
                    ->paginate(25);

        //$notApprovedCount = Book::whereNull('is_approved')->count();

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
    public function store(StoreBookRequest $request)
    {
        $book = Book::createBookWithAuthorsGenres($request->all());

        $book->is_approved = 1;

        if($request->hasFile('image')){
            $book->image = ImageService::storeImage($request);
        }

        $book->save();

        return redirect(route('admin.books.index'))
            ->with('success', 'Book saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $review = null;
        if(auth()->user()){
            $review = auth()->user()->reviews->where('book_id', $book->id)->first();
        }

        $book->load('reviews')->load('user');

        return view('book.show', compact(['book', 'review']));
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
    public function update(StoreBookRequest $request, Book $book)
    {
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->price = $request->input('price');
        $book->discount = $request->input('discount');
        $book->genres()->sync($request['genres']);
        $book->is_approved = 1;
        $authors = explode(',', $request['authors']);

        foreach($authors as $authorName){
            $author = Author::updateOrCreate(['name' => $authorName]);
            $book->authors()->sync($author->id);
        }

        if($request->hasFile('image')){
            $book->image = ImageService::storeImage($request);
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
        $book->delete();

        return redirect(route('admin.books.index'))->with('success', 'Book deleted!');
    }
}
