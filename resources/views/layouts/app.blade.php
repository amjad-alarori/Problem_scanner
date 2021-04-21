<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/logos/eye orange eye - favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/img/logos/orange_eyes.jpg" style="height:40px;">
            </a>
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
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                            <li class="nav-item">
                                <a class="nav-link" href="/scan">Scans</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/results">Resultaten</a>
                            </li>
                        @if(Auth::user()->roles->first()->level == 2 || Auth::user()->roles->first()->level == 3)
                            <li class="nav-item">
                                <a class="nav-link" href="/consulent">Clienten</a>
                            </li>
                        @endif

                        @if(Auth::user()->isAdmin())

                            @if(isset($_SERVER['REQUEST_URI']))
                                @if (strpos($_SERVER['REQUEST_URI'],'admin'))

                                @endif
                            @endif
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->isAdmin())
                            <div id="adminNav">
                                <a class="dropdown-item text text-danger" href="{{route('admin')}}">Admin</a>
                            </div>
                            @if(isset($_SERVER['REQUEST_URI']))
                                @if (strpos($_SERVER['REQUEST_URI'],'admin'))
                                        <a class="dropdown-item" href="/">Terug naar website</a><br>
                                    <script>
                                        $('#adminNav').empty();
                                    </script>
                                            <a class="dropdown-item" href="{{route('categories.index')}}">
                                                Categories
                                            </a>
                                            <a class="dropdown-item" href="{{route('questions.index')}}">
                                                Questions
                                            </a>
                                @endif
                            @endif
                        @endif<a class="dropdown-item" href="{{route('account.index')}}">
                                Account
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

    <main class="py-0">
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>

