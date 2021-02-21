<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use App\Models\User;
use App\Notifications\BookReportNotification;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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
                    ->when(request('user_books') && Auth::check(), function ($query) {
                        $query->where('user_id', auth()->user()->id)
                            ->whereNotNull('is_approved')
                            ->orWhere(function($query){
                                    $query->whereNull('is_approved')
                                        ->where('user_id', auth()->user()->id);
                                });
                    })
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

        if($request->hasFile('image')){
            $book->image = ImageService::storeImage($request);
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
        $review = null;
        if(auth()->user()){
            $review = auth()->user()->reviews->where('book_id', $book->id)->first();
        }

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
        $book->is_approved = null;
        $authors = explode(',', $request['authors']);

        foreach($authors as $authorName){
            $author = Author::updateOrCreate(['name' => $authorName]);
            $book->authors()->sync($author->id);
        }

        if($request->hasFile('image')){
            $book->image = ImageService::storeImage($request);
        }

        $book->save();

        return redirect(route('admin.books.index'))->with('success','Book saved, but will only be visible when approved by admin');
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

    /**
     * Sends notification after user reports book
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function report(Book $book)
    {
        $adminEmails = User::whereHas('roles', function($query){
            $query->where('name', 'admin');
        })->get();

        Notification::send($adminEmails, new BookReportNotification($book));

        return redirect()->route('user.books.show', $book->id)->with('success', 'Book reported!');
    }
}
