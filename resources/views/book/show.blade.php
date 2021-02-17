@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
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
                    @if($book->image)
                        <img class="card-img-top pl-4 pr-4 pt-4" src="{{URL::to('Storage/Images/'.$book->image)}}" title="{{$book->title}}" width="100%" />
                    @else
                        <img class="card-img-top pl-4 pr-4 pt-4" src="{{URL::to('Storage/Images/default_image.png')}}" title="{{$book->title}}" width="100%" />
                    @endif
                    <div class="card-body p-2 ">
                        <p class="card-text">
                            <hr />
                            <b>{{$book->title}}</b>
                        </p>
                    </div>
                    <div class="card-footer p-3">
                    @forelse($book->authors as $author)
                        @if ($loop->first)By @endif{{$author->name}}@if(!$loop->last), @endif
                    @empty
                    @endforelse

                    @forelse($book->genres as $genre)
                        @if ($loop->first)<hr />[@endif{{$genre->name}}@if(!$loop->last), @endif{{''}}@if($loop->last)]@endif
                    @empty
                    @endforelse

                    @can('is-admin')
                        <a class="btn btn-primary"href="{{route('admin.books.edit', $book)}}">Edit</a>
                    @else
                        <a class="btn btn-primary"href="{{route('user.books.edit', $book)}}">Edit</a>
                    @endcan
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
                @auth
                <h5 class="mb-2 mt-3">Write a review</h5>
                <div class="card shadow-sm bg-white rounded-lg">
                    <div class="card-body p-2">
                        <form method="POST" action="{{route('user.reviews.store')}}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{$book->id}}" />
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select name="rating" class="form-control" id="rating" required>
                        @for ($i = 1; $i <= 10; $i++)
                                <option value="{{$i}}" @isset($review) @if($review->rating == $i) selected @endif @endisset>
                                    {{$i}} -
                                    @for ($j = 10; $j >= 1; $j--)
                                        @if($i >= $j)
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                @endauth
                <h5 class="mt-4 mb-2">Users reviews</h5>
            @forelse ($book->reviews as $review)
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
                <!--div class="card shadow-sm bg-white rounded-lg">
                    <div class="card-body p-0">
                        <p class="card-text p-2">
                            This book has no reviews :(
                        </p>
                    </div>
                </div-->
            @endforelse
            </div>
        </div>
    </div>
@endsection
