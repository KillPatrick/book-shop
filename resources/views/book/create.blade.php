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
                        <form method="POST" enctype="multipart/form-data" action="{{route('admin.books.store')}}" >
                    @else
                        <form method="POST" enctype="multipart/form-data" action="{{route('user.books.store')}}">
                    @endif
                    @include('book.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
