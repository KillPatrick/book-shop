@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                Personal information
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('user-profile-information.update') }}">
                            {{ method_field('PUT') }}
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="text-md-right">{{ __('Name') }}</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required autocomplete="name">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="text-md-right">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                Change password
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('user-password.update') }}">
                            {{ method_field('PUT') }}
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="current_password" class="text-md-right">{{ __('Current password') }}</label>
                                    <input id="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" name="current_password" value="" required autocomplete="new-password">
                                    @error('current_password', 'updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="password" class="text-md-right">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password" value="" required autocomplete="new-password">
                                    @error('password', 'updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="text-md-right">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Change password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
