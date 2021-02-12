@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card m-2 shadow-sm bg-white rounded-lg">
                    <h4 class="sticky-top position-absolute ml-1 mt-1">
                        <span class="badge badge-secondary">{{$book->price}} &euro;</span>
                        @if($book->discount)<span class="badge badge-success">-{{$book->discount}}%</span>@endif
                        @if($book->new)<span class="badge badge-danger">New</span>@endif
                    </h4>
                    <img class="card-img-top pt-5 pl-5 pr-5 w-75" src="{{URL::to('Storage/Images/'.$book->image)}}" title="{{$book->title}}" />
                    <div class="card-body p-2 ">
                        <p class="card-text">
                            <b>{{$book->title}}</b>
                        </p>
                    </div>
                    <div class="card-footer p-2">
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
            <div class="col-md-5">
                <div class="card m-2 shadow-sm bg-white rounded-lg">
                    <div class="card-body p-2 ">
                        <p class="card-text">
                            {{$book->description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
