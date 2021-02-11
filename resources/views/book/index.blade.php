@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
        @foreach ($books as $book)
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <small>{{ $book->title }}</small>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><img src="Storage/Images/{{$book->image}}" title="{{$book->title}}" width="100%" /></p>
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
                    {{$books->links()}}
            </div>
        </div>
    </div>
@endsection
