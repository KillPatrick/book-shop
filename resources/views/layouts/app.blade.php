<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="api-base-url" content="{{ $_SERVER['SERVER_NAME'] }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Book-shop</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .dropdown-menu {
           z-index: 10000;
        }
        .rating-star{
            text-shadow: black 0.1em 0.1em 0.1em;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
            @guest
                    <a class="navbar-brand" href="{{route('guest.books.index')}}">Book-shop</a>
            @else
                @can('is-admin')
                    <a class="navbar-brand" href="{{route('admin.books.index')}}">Book-shop</a>
                @else
                    <a class="navbar-brand" href="{{route('user.books.index')}}">Book-shop</a>
                @endcan
            @endguest
                <form class="form-inline my-2 my-lg-0" method="GET"
                @guest
                    action="{{route('guest.books.index')}}"
                @else
                    action="@can('is-admin') {{route('admin.books.index')}} @else{{route('user.books.index')}} @endcan"
                @endguest
                >
                    <input class="form-control mr-sm-2" type="search" placeholder="Title, description, author, genre" name="search" aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0 mr-3" type="submit">Search</button>
                </form>
                @auth
                    @isset($notApprovedCount)
                        @if($notApprovedCount)
                            <a class="navbar-brand" href="{{route('admin.books.index', ['not_approved' => 1])}}">Not approved <span class="badge badge-pill badge-danger">{{$notApprovedCount}}</span></a>
                        @endif
                    @endisset
                    @isset($userBookCount)
                        @if($userBookCount)
                            @can('is-admin')
                                <a class="navbar-brand" href="{{route('admin.books.index', ['user_books' => 1])}}">My books <span class="badge badge-pill badge-success">{{$userBookCount}}</span></a>
                            @else
                                <a class="navbar-brand" href="{{route('user.books.index', ['user_books' => 1])}}">My books <span class="badge badge-pill badge-success">{{$userBookCount}}</span></a>
                            @endcan
                        @endif
                    @endisset
                    @can('is-admin')
                        <a class="navbar-brand" href="{{route('admin.books.create')}}">Add a book</a>
                    @else
                        <a class="navbar-brand" href="{{route('user.books.create')}}">Add a book</a>
                    @endcan
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Sign up') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('user.users.index')}}" >
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @if(Session::has('success'))
            <div class="row">
                <div class="col-md-12 pt-1">
                    <div class="alert alert-success ml-2 mr-2"> {{ Session::get('success') }}</div>
                </div>
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
