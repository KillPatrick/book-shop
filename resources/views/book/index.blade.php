@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
        @foreach ($books as $book)
                    <div class="col mb-2">
                        <div class="card m-2 shadow-sm bg-white rounded-lg">
                            <h4 class="sticky-top position-absolute ml-2 mt-2">
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
                            <!--h3 class="badge badge-danger sticky-top position-absolute">{{$book->price}} &euro;</h3-->
                            <a href="{{route('book.show', $book->id)}}">
                                <img class="card-img-top pl-4 pr-4 pt-4" src="{{URL::to('Storage/Images/'.$book->image)}}" title="{{$book->title}}" width="100%" />
                            </a>
                            <div class="card-body p-2">
                                <p class="card-text">
                                    <hr />
                            @for($i = 1; $i <= 10; $i++)
                                @if($i <= $book->reviewsRating())
                                    <span class="text-warning rating-star">&#9733;</span>
                                @else
                                    <span class="rating-star">&#9733;</span>
                                @endif
                            @endfor
                                    <hr />
                                    <b>{{$book->title}}</b>
                                </p>
                            </div>
                            <div class="card-footer p-2">
                                <small>
                @forelse($book->authors as $author)
                   @if ($loop->first)By @endif{{$author->name}}@if(!$loop->last), @endif
                @empty
                @endforelse

                @forelse($book->genres as $genre)
                        @if ($loop->first)<hr />[@endif<a href="#">{{$genre->name}}</a>@if(!$loop->last), @endif{{''}}@if($loop->last)]@endif
                    @empty
                @endforelse
                            </small>
                            </div>
                        </div>
                    </div>
            @if($loop->iteration % 5 == 0)
                </div>
            @endif
            @if($loop->iteration % 5 == 0)
                <div class="row">
            @endif
        @endforeach
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 d-flex justify-content-center">
                {{$books->links()}}
            </div>
        </div>
    </div>
@endsection
