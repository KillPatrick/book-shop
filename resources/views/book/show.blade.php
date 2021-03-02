@extends('layouts.app')

@section('content')
    @auth
        <div id="app">
            <index-index book_id="{{$book->id}}"></index-index>
        </div>
    @else
        <div class="container">
            <div class="row justify-content-center">
                @if(!$book->is_approved)
                    <div class="alert alert-info col-md-12">This book is not approved and not visible to other users, admin must edit and save this book.</div>
                @endif
                <div class="col-md-6">
                    <div class="card shadow-sm bg-white rounded-lg">
                        <h4 class="sticky-top position-absolute ml-2 mt-1">
                            @if($book->discount)
                                <span class="badge badge-secondary shadow-sm">{{$book->discountedPrice()}} &euro;</span>
                                <span class="badge badge-success shadow-sm">-{{$book->discount}}%</span>
                            @else
                                <span class="badge badge-secondary shadow-sm">{{$book->price}} &euro;</span>
                            @endif
                            @if($book->new())
                                <span class="badge badge-warning shadow-sm">New</span>
                            @endif
                        </h4>
                        <img class="mx-auto pt-5" src="{{URL::to($book->image_path)}}" title="{{$book->title}}" width="50%" />
                        <div class="card-body p-2">
                            <p class="card-text">
                                <hr />
                                <b>{{$book->title}}</b>
                            </p>
                        </div>
                        <div class="card-footer p-3">
                            @for($i = 1; $i <= 10; $i++)
                                @if($book->reviews->count() && $i <= ($book->reviews->sum('rating') / $book->reviews->count()))
                                    <span class="text-warning rating-star">&#9733;</span>
                                @else
                                    <span class="rating-star">&#9733;</span>
                                @endif
                            @endfor
                            <hr />
                        @forelse($book->authors as $author)
                            @if ($loop->first)By @endif{{$author->name}}@if(!$loop->last), @endif
                        @empty
                        @endforelse

                        @forelse($book->genres as $genre)
                            @if ($loop->first)<hr />[@endif{{$genre->name}}@if(!$loop->last), @endif{{''}}@if($loop->last)]@endif
                        @empty
                        @endforelse
                        <hr />
                        @auth
                            <div class="btn-toolbar">
                                <div class="btn-group mr-1">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">Write a review</button>
                                </div>
                                @can('is-admin')
                                    <div class="btn-group mr-1">
                                        <a class="btn btn-primary"href="{{route('admin.books.edit', $book)}}">Edit</a>
                                    </div>
                                    <div class="btn-group mr-1">
                                        <form method="POST" action="{{route('admin.books.destroy', $book)}}">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="btn-group mr-1">
                                        <form method="POST" action="{{route('user.books.report', $book)}}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to report this book?');">Report</button>
                                        </form>
                                    </div>
                                    @can('is-book-owner', $book->id)
                                        <div class="btn-group mr-1">
                                            <a class="btn btn-primary"href="{{route('user.books.edit', $book)}}">Edit</a>
                                        </div>
                                        <div class="btn-group mr-1">
                                            <form method="POST" action="{{route('user.books.destroy', $book)}}">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                                            </form>
                                        </div>
                                    @endcan
                                @endcan
                            </div>
                        @endauth
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-2">Description</h5>
                    <div class="card shadow-sm bg-white rounded-lg">
                        <div class="card-body p-0">
                            <p class="card-text p-2">
                                {{$book->description}}
                            </p>
                        </div>
                    </div>
                    @forelse ($book->reviews as $review)
                        @if($loop->first) <h5 class="mt-4 mb-2">Users reviews</h5> @endif
                        <div class="card shadow-sm bg-white rounded-lg mb-3">
                            <div class="card-body p-0">
                                <div class="card-header">
                                    <h5>{{$review->title}}</h5>
                                    <hr />
                                    <p>
                                        @for($i = 1; $i <= 10; $i++)
                                            @if($i <= $review->rating)
                                                <span class="text-warning rating-star">&#9733;</span>
                                            @else
                                                <span class="rating-star">&#9733;</span>
                                            @endif
                                        @endfor
                                    </p>
                                </div>
                                <p class="card-text p-2">
                                    {{$review->review}}
                                </p>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        @auth
            <div class="modal" id="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Write a review</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @isset($review)
                        <form method="POST" action="{{route('user.reviews.update', $review->id)}}">
                        {{ method_field('PUT') }}
                    @else
                        <form method="POST" action="{{route('user.reviews.store')}}">
                        <input type="hidden" name="book_id" value="{{$book->id}}" />
                    @endisset
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" class="form-control" id="rating" required>
                                    @for ($i = 10; $i >= 1; $i--)
                                        <option value="{{$i}}" @isset($review) @if($review->rating == $i) selected @endif @endisset>
                                            {{$i}} -
                                            @for ($j = 1; $j <= 10; $j++)
                                                @if($j <= $i)
                                                    &#9733;
                                                @endif
                                            @endfor
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title" value="@isset($review){{$review->title}}@else{{ old('title') }}@endisset" required>
                            </div>
                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea class="form-control" name="review" id="review" rows="5" required>@isset($review){{$review->review}}@else{{ old('description') }}@endisset</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    @endauth
@endsection
