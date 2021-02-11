@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
        @foreach ($books as $book)
                    <div class="col mb-2">
                        <div class="card m-2 shadow-sm bg-white rounded-lg">
                            <h4 class="sticky-top position-absolute mt-2">
                                <span class="badge badge-secondary">{{$book->price}} &euro;</span>
                                @if($book->discount)<span class="badge badge-success">-{{$book->discount}}%</span>@endif
                                @if($book->new)<span class="badge badge-danger">New</span>@endif
                            </h4>
                            <!--h3 class="badge badge-danger sticky-top position-absolute">{{$book->price}} &euro;</h3-->
                            <img class="card-img-top" src="Storage/Images/{{$book->image}}" title="{{$book->title}}" width="100%" />
                            <div class="card-body p-2 ">
                                <p class="card-text">
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
                    @if ($loop->first)<hr />[@endif{{$genre->name}}@if(!$loop->last), @endif{{''}}@if($loop->last)]@endif
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
            <div class="col-md-10 d-flex justify-content-center">
                {{$books->links()}}
            </div>
        </div>
    </div>
@endsection
