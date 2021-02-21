@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <h4>Add your book</h4>
                    @can('is-admin')
                        <form method="POST" enctype="multipart/form-data" action="{{route('admin.books.update', $book->id)}}" >
                    @else
                        <form method="POST" enctype="multipart/form-data" action="{{route('user.books.update', $book->id)}}">
                    @endif
                        {{ method_field('PUT') }}
                    @include('book.form', $book)
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
