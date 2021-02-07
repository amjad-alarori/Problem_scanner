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
    <script src="{{ asset('js/app.js') }}"></script>
    <style>@keyframes swing {
               0% {
                   transform: rotate(0deg);
               }
               10% {
                   transform: rotate(10deg);
               }
               30% {
                   transform: rotate(0deg);
               }
               40% {
                   transform: rotate(-10deg);
               }
               50% {
                   transform: rotate(0deg);
               }
               60% {
                   transform: rotate(5deg);
               }
               70% {
                   transform: rotate(0deg);
               }
               80% {
                   transform: rotate(-5deg);
               }
               100% {
                   transform: rotate(0deg);
               }
           }

        @keyframes sonar {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        body {
            font-size: 0.9rem;
        }

        .page-wrapper .sidebar-wrapper,
        .sidebar-wrapper .sidebar-brand > a,
        .sidebar-wrapper .sidebar-dropdown > a:after,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before,
        .sidebar-wrapper ul li a i,
        .page-wrapper .page-content,
        .sidebar-wrapper .sidebar-search input.search-menu,
        .sidebar-wrapper .sidebar-search .input-group-text,
        .sidebar-wrapper .sidebar-menu ul li a,
        #show-sidebar,
        #close-sidebar {
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        /*----------------page-wrapper----------------*/

        .page-wrapper {
            height: 100vh;
        }

        .page-wrapper .theme {
            width: 40px;
            height: 40px;
            display: inline-block;
            border-radius: 4px;
            margin: 2px;
        }

        .page-wrapper .theme.chiller-theme {
            background: #1e2229;
        }

        /*----------------toggeled sidebar----------------*/

        .page-wrapper.toggled .sidebar-wrapper {
            left: 0px;
        }

        @media screen and (min-width: 768px) {
            .page-wrapper.toggled .page-content {
                padding-left: 300px;
            }
        }

        /*----------------show sidebar button----------------*/
        #show-sidebar {
            position: fixed;
            left: 0;
            top: 10px;
            border-radius: 0 4px 4px 0px;
            width: 35px;
            transition-delay: 0.3s;
        }

        .page-wrapper.toggled #show-sidebar {
            left: -40px;
        }

        /*----------------sidebar-wrapper----------------*/

        .sidebar-wrapper {
            width: 260px;
            height: 100%;
            max-height: 100%;
            position: fixed;
            top: 0;
            left: -300px;
            z-index: 999;
        }

        .sidebar-wrapper ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-wrapper a {
            text-decoration: none;
        }

        /*----------------sidebar-content----------------*/

        .sidebar-content {
            max-height: calc(100% - 30px);
            height: calc(100% - 30px);
            overflow-y: auto;
            position: relative;
        }

        .sidebar-content.desktop {
            overflow-y: hidden;
        }

        /*--------------------sidebar-brand----------------------*/

        .sidebar-wrapper .sidebar-brand {
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .sidebar-wrapper .sidebar-brand > a {
            text-transform: uppercase;
            font-weight: bold;
            flex-grow: 1;
        }

        .sidebar-wrapper .sidebar-brand #close-sidebar {
            cursor: pointer;
            font-size: 20px;
        }

        /*--------------------sidebar-header----------------------*/

        .sidebar-wrapper .sidebar-header {
            padding: 20px;
            overflow: hidden;
        }

        .sidebar-wrapper .sidebar-header .user-pic {
            float: left;
            width: 60px;
            padding: 2px;
            border-radius: 12px;
            margin-right: 15px;
            overflow: hidden;
        }

        .sidebar-wrapper .sidebar-header .user-pic img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .sidebar-wrapper .sidebar-header .user-info {
            float: left;
        }

        .sidebar-wrapper .sidebar-header .user-info > span {
            display: block;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-role {
            font-size: 12px;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-status {
            font-size: 11px;
            margin-top: 4px;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-status i {
            font-size: 8px;
            margin-right: 4px;
            color: #5cb85c;
        }

        /*-----------------------sidebar-search------------------------*/

        .sidebar-wrapper .sidebar-search > div {
            padding: 10px 20px;
        }

        /*----------------------sidebar-menu-------------------------*/

        .sidebar-wrapper .sidebar-menu {
            padding-bottom: 10px;
        }

        .sidebar-wrapper .sidebar-menu .header-menu span {
            font-weight: bold;
            font-size: 14px;
            padding: 15px 20px 5px 20px;
            display: inline-block;
        }

        .sidebar-wrapper .sidebar-menu ul li a {
            display: inline-block;
            width: 100%;
            text-decoration: none;
            position: relative;
            padding: 8px 30px 8px 20px;
        }

        .sidebar-wrapper .sidebar-menu ul li a i {
            margin-right: 10px;
            font-size: 12px;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 4px;
        }

        .sidebar-wrapper .sidebar-menu ul li a:hover > i::before {
            display: inline-block;
            animation: swing ease-in-out 0.5s 1 alternate;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown > a:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f105";
            font-style: normal;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-align: center;
            background: 0 0;
            position: absolute;
            right: 15px;
            top: 14px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu ul {
            padding: 5px 0;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li {
            padding-left: 25px;
            font-size: 13px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before {
            content: "\f111";
            font-family: "Font Awesome 5 Free";
            font-weight: 400;
            font-style: normal;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin-right: 10px;
            font-size: 8px;
        }

        .sidebar-wrapper .sidebar-menu ul li a span.label,
        .sidebar-wrapper .sidebar-menu ul li a span.badge {
            float: right;
            margin-top: 8px;
            margin-left: 5px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .badge,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .label {
            float: right;
            margin-top: 0px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-submenu {
            display: none;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a:after {
            transform: rotate(90deg);
            right: 17px;
        }

        /*--------------------------side-footer------------------------------*/

        .sidebar-footer {
            position: absolute;
            width: 100%;
            bottom: 0;
            display: flex;
        }

        .sidebar-footer > a {
            flex-grow: 1;
            text-align: center;
            height: 30px;
            line-height: 30px;
            position: relative;
        }

        .sidebar-footer > a .notification {
            position: absolute;
            top: 0;
        }

        .badge-sonar {
            display: inline-block;
            background: #980303;
            border-radius: 50%;
            height: 8px;
            width: 8px;
            position: absolute;
            top: 0;
        }

        .badge-sonar:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            border: 2px solid #980303;
            opacity: 0;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            animation: sonar 1.5s infinite;
        }

        /*--------------------------page-content-----------------------------*/

        .page-wrapper .page-content {
            display: inline-block;
            width: 100%;
            padding-left: 0px;
            padding-top: 20px;
        }

        .page-wrapper .page-content > div {
            padding: 20px 40px;
        }

        .page-wrapper .page-content {
            overflow-x: hidden;
        }

        /*------scroll bar---------------------*/

        ::-webkit-scrollbar {
            width: 5px;
            height: 7px;
        }

        ::-webkit-scrollbar-button {
            width: 0px;
            height: 0px;
        }

        ::-webkit-scrollbar-thumb {
            background: #525965;
            border: 0px none #ffffff;
            border-radius: 0px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #525965;
        }

        ::-webkit-scrollbar-thumb:active {
            background: #525965;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
            border: 0px none #ffffff;
            border-radius: 50px;
        }

        ::-webkit-scrollbar-track:hover {
            background: transparent;
        }

        ::-webkit-scrollbar-track:active {
            background: transparent;
        }

        ::-webkit-scrollbar-corner {
            background: transparent;
        }


        /*-----------------------------chiller-theme-------------------------------------------------*/

        .chiller-theme .sidebar-wrapper {
            background: #f2f2f2;
        }

        .chiller-theme .sidebar-wrapper .sidebar-header,
        .chiller-theme .sidebar-wrapper .sidebar-search,
        .chiller-theme .sidebar-wrapper .sidebar-menu {
            border-top: 1px solid #cecece;
        }

        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
        .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
            border-color: transparent;
            box-shadow: none;
        }

        .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-role,
        .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-status,
        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
        .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text,
        .chiller-theme .sidebar-wrapper .sidebar-brand > a,
        .chiller-theme .sidebar-wrapper .sidebar-menu ul li a,
        .chiller-theme .sidebar-footer > a {
            color: black;
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu ul li:hover > a,
        .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a,
        .chiller-theme .sidebar-wrapper .sidebar-header .user-info,
        .chiller-theme .sidebar-wrapper .sidebar-brand > a:hover,
        .chiller-theme .sidebar-footer > a:hover i {
            color: #ec6608;
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu li:hover {
            background-color: #e6e6e6;
        }

        .page-wrapper.chiller-theme.toggled #close-sidebar {
            color: #ec6608;
        }

        .page-wrapper.chiller-theme.toggled #close-sidebar:hover {
            color: #ec6608;
        }

        .chiller-theme .sidebar-wrapper ul li:hover a i,
        .chiller-theme .sidebar-wrapper .sidebar-dropdown .sidebar-submenu li a:hover:before,
        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu:focus + span,
        .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active a i {
            color: #ec6608;
            text-shadow: 0px 0px 10px rgba(22, 199, 255, 0.5);
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu ul li a i,
        .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown div,
        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
        .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
            background: #cecece;
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu .header-menu span {
            color: #6c7b88;
        }

        .chiller-theme .sidebar-footer {
            background: #cecece;
            box-shadow: 0px -1px 5px #cbcbcb;
            border-top: 1px solid #cecece;
        }

        .chiller-theme .sidebar-footer > a:first-child {
            border-left: none;
        }

        .chiller-theme .sidebar-footer > a:last-child {
            border-right: none;
        }
        .custom-link-hover{

        }

        .custom-link-hover:hover{
            color:#ec6608;
            background-color:#f2f2f2;
        }
    </style>

</head>
<body>
<div id="app">
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <img src="/img/logos/orange_eyes-removebg-preview.png" style="height:40px;margin-right:5px;">
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded"
                             src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                             alt="User picture">
                    </div>
                    <div class="user-info">
          <span class="user-name">
            <strong> {{ Auth::user()->name }}</strong>
          </span>
                        <span class="user-role">Administrator</span>
                        <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>

          </span>
                        <a class=" p-0 pb-2 dropdown-item custom-link-hover" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}   <i class="mt-1 fa fa-sign-out-alt fa-lg" ></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                </div>
                <!-- sidebar-header  -->

                <div class="sidebar-search">
                    <div>
                        <div class="input-group">
                            <form action="{{route('search')}}" method="post">@csrf
                                <div class="input-group-append">
                                    <input type="text" class="form-control search-menu" name="query"
                                           placeholder="Search...">
                                    <span class="input-group-text">
                <button style="border:none; background-color:#CECECE; border-radius: 0;" type="submit"
                        class="fa fa-search" aria-hidden="true"></button>
              </span></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- sidebar-search  -->
                <div class="sidebar-menu">
                    <ul>@if(isset($_SERVER['REQUEST_URI']))
                            @if (strpos($_SERVER['REQUEST_URI'],'admin'))
                                <li><a href="/" style="color:#FFF;" class="btn btn-success">Terug naar website</a><br>
                                </li>

                                <script>
                                    $('#adminNav').empty();
                                </script>

                            @endif
                        @endif
                        <li class="header-menu">
                            <span>{{Auth::user()->name}}</span>
                        </li>

                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#"> <i class="fa fa-briefcase"></i>Categorieën<span
                                    class="badge badge-pill badge-warning">{{count(\App\Models\Categories::withTrashed()->get())}}</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="{{route('categories.index')}}">
                                            <span>Overzicht</span>
                                            <span
                                                class="badge badge-pill badge-success ">{{count(\App\Models\Categories::all())}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('categories.trashed')}}">
                                            <span>Prullenbak</span>
                                            <span
                                                class="badge badge-pill badge-danger">{{count(\App\Models\Categories::onlyTrashed()->get())}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#"> <i class="fa fa-question"></i>Questions<span
                                    class="badge badge-pill badge-warning">{{count(\App\Models\Questions::withTrashed()->get())}}</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="{{route('questions.index')}}">
                                            <span>Overzicht</span>
                                            <span
                                                class="badge badge-pill badge-success ">{{count(\App\Models\Questions::all())}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('questions.trashed')}}">
                                            <span>Prullenbak</span>
                                            <span
                                                class="badge badge-pill badge-danger">{{count(\App\Models\Questions::onlyTrashed()->get())}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#"> <i class="fa fa-qrcode"></i>Scans<span
                                    class="badge badge-pill badge-warning">{{count(\App\Models\Scan::withTrashed()->get())}}</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="{{route('scan.index')}}">
                                            <span>Overzicht</span>
                                            <span
                                                class="badge badge-pill badge-success ">{{count(\App\Models\Scan::all())}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('scan.trashed')}}">
                                            <span>Prullenbak</span>
                                            <span
                                                class="badge badge-pill badge-danger">{{count(\App\Models\Scan::onlyTrashed()->get())}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#"> <i class="fa fa-tachometer-alt"></i>Resultaten<span
                                    class="badge badge-pill badge-warning">{{count(\App\Models\Results::withTrashed()->get())}}</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="{{route('results.index')}}">
                                            <span>Overzicht</span>
                                            <span
                                                class="badge badge-pill badge-success ">{{count(\App\Models\Results::all())}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('results.trashed')}}">
                                            <span>Prullenbak</span>
                                            <span
                                                class="badge badge-pill badge-danger">{{count(\App\Models\Results::onlyTrashed()->get())}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="header-menu">
                            <span>CMS</span>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#"> <i class="fa fa-user"></i>Gebruikers<span
                                    class="badge badge-pill badge-warning">{{count(\App\Models\User::withTrashed()->get())}}</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="{{route('user.index')}}">
                                            <span>Overzicht</span>
                                            <span
                                                class="badge badge-pill badge-success ">{{count(\App\Models\User::all())}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('user.trashed')}}">
                                            <span>Prullenbak</span>
                                            <span
                                                class="badge badge-pill badge-danger">{{count(\App\Models\User::onlyTrashed()->get())}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-content pr-0"><a class="pr-3" href="{{route('roles.index')}}"><i class="fa fa-tag"></i>Rollen  <b> <span class="fa fa-chevron-right fa-xs mt-2 ml-2 float-right "></span></b>    <span
                                    class="badge badge-pill badge-warning">{{count(\jeremykenedy\LaravelRoles\Models\Role::withTrashed()->get())}}</span></a></li>

                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
            {{--            <div class="sidebar-footer">--}}
            {{--                <a href="#">--}}
            {{--                    <i class="fa fa-bell"></i>--}}
            {{--                    <span class="badge badge-pill badge-warning notification">3</span>--}}
            {{--                </a>--}}
            {{--                <a href="#">--}}
            {{--                    <i class="fa fa-envelope"></i>--}}
            {{--                    <span class="badge badge-pill badge-success notification">7</span>--}}
            {{--                </a>--}}
            {{--                <a href="#">--}}
            {{--                    <i class="fa fa-cog"></i>--}}
            {{--                    <span class="badge-sonar"></span>--}}
            {{--                </a>--}}
            {{--                <a href="#">--}}
            {{--                    <i class="fa fa-power-off"></i>--}}
            {{--                </a>--}}
            {{--            </div>--}}
        </nav>

        <main class="page-content py-0">
            @yield('content')
        </main>
    </div>

</div>
<script>

    $(".sidebar-dropdown > a").click(function () {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
                .parent()
                .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function () {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function () {
        $(".page-wrapper").addClass("toggled");
    });
</script>
@stack('scripts')
</body>
</html>

