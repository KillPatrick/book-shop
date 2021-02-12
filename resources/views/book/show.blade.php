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
                            <span class="badge badge-danger shadow-sm">New</span>
                        @endif
                    </h4>
                    <img class="card-img-top pt-5 pl-5 pr-5 w-100" src="{{URL::to('Storage/Images/'.$book->image)}}" title="{{$book->title}}" />
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
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="mb-2">Description:</h5>
                <div class="card shadow-sm bg-white rounded-lg">
                    <div class="card-body p-0">
                        <p class="card-text p-2">
                            {{$book->description}}
                        </p>
                    </div>
                </div>
                <h5 class="mt-4 mb-2">Users reviews:</h5>
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
                <div class="card shadow-sm bg-white rounded-lg">
                    <div class="card-body p-0">
                        <p class="card-text p-2">
                            This book has no reviews :(
                        </p>
                    </div>
                </div>
            @endforelse
            </div>
        </div>
    </div>
@endsection
