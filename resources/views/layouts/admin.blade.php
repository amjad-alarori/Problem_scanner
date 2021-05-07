<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/logos/eye orange eye - favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="overlay-scrollbar">
    <script>
        const body = document.getElementsByTagName('body')[0]
        if (localStorage.getItem('sidebar') == "true") {
            body.classList.toggle('sidebar-expand')
        }
    </script>
    <!-- navbar -->
    <div class="navbar">
        <!-- nav left -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link mx-3">
                    <i class="fas fa-bars" style="transform: translateY(5px);" onclick="collapseSidebar()"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-nav">
            <li class="nav-item">
                <img src="https://orange-eyes-images.s3.eu-central-1.amazonaws.com/logos/logo.png"
                     class="logo logo-light">
            </li>
        </div>
        <!-- end nav left -->
        <!-- form -->
        <form class="navbar-search">
            <input type="text" name="Search" class="navbar-search-input" placeholder="Search...">
            <i class="fas fa-search"></i>
        </form>
        <!-- end form -->
        <!-- nav right -->
        <li class="nav-item dropdown mr-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item text-danger"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        <!-- end nav right -->
    </div>
    <!-- end navbar -->
    <!-- sidebar -->
    @include('_partials.admin.sidebar', ['items' => [
        [
            'name' => 'Terug naar website',
            'icon' => 'fa fa-hand-point-left',
            'href' => '/'
        ],
        [
            'name' => 'Systeem'
        ],
        [
            'name' => 'Email',
            'icon' => 'fa fa-envelope',
            'items' => [
                [
                    'name' => 'Translations',
                    'icon' => 'fa fa-language',
                    'href' => route('emailtranslation.index')
                ],
                [
                    'name' => 'Component translations',
                    'icon' => 'fa fa-cubes',
                    'href' => route('emailcomponenttranslation.index')
                ]
            ]
        ],
        [
            'name' => 'System configuration',
            'icon' => 'fa fa-tools',
            'href' => route('appconfig.index')
        ],
        [
            'name' => 'General'
        ],
        [
            'name' => 'Categorieën',
            'icon' => 'fa fa-network-wired',
            'items' => [
                [
                    'name' => 'Overzicht',
                    'icon' => 'fa fa-list',
                    'href' => route('categories.index')
                ],
                [
                    'name' => 'Prullenbak',
                    'icon' => 'fa fa-trash-alt',
                    'href' => route('categories.trashed')
                ]
            ]
        ],
        [
            'name' => 'Questions',
            'icon' => 'fa fa-question',
            'items' => [
                [
                    'name' => 'Overzicht',
                    'icon' => 'fa fa-list',
                    'href' => route('questions.index')
                ],
                [
                    'name' => 'Prullenbak',
                    'icon' => 'fa fa-trash-alt',
                    'href' => route('questions.trashed')
                ]
            ]
        ],
        [
            'name' => 'Scans',
            'icon' => 'fa fa-clipboard-list',
            'items' => [
                [
                    'name' => 'Overzicht',
                    'icon' => 'fa fa-list',
                    'href' => route('scan.index')
                ],
                [
                    'name' => 'Prullenbak',
                    'icon' => 'fa fa-trash-alt',
                    'href' => route('scan.trashed')
                ]
            ]
        ],
        [
            'name' => 'Resultaten',
            'icon' => 'fa fa-poll-h',
            'items' => [
                [
                    'name' => 'Overzicht',
                    'icon' => 'fa fa-list',
                    'href' => route('results.index')
                ],
                [
                    'name' => 'Prullenbak',
                    'icon' => 'fa fa-trash-alt',
                    'href' => route('results.trashed')
                ]
            ]
        ],
        [
            'name' => 'CMS'
        ],
        [
            'name' => 'Gebruikers',
            'icon' => 'fa fa-users',
            'items' => [
                [
                    'name' => 'Overzicht',
                    'icon' => 'fa fa-list',
                    'href' => route('user.index')
                ],
                [
                    'name' => 'Prullenbak',
                    'icon' => 'fa fa-trash-alt',
                    'href' => route('user.trashed')
                ]
            ]
        ],
        [
            'name' => 'Rollen',
            'icon' => 'fa fa-user-tag',
            'href' => route('roles.index')
        ],
    ]])
    <div class="wrapper">
        @yield('content')
    </div>
    <script>
        function collapseSidebar() {
            body.classList.toggle('sidebar-expand')
            localStorage.setItem('sidebar', $(body).hasClass('sidebar-expand'));
        }
    </script>
    @stack('scripts')
</body>
</html>
