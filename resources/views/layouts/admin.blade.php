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
    <script src="{{ asset('js/admin.js') }}"></script>
</head>
<body class="overlay-scrollbar">
    <script>
        const body = document.getElementsByTagName('body')[0]
        if (localStorage.getItem('sidebar') == "true") {
            body.classList.toggle('sidebar-expand')
        }
    </script>
    <!-- navbar -->
    @include('_partials.admin.navbar')
    <!-- end navbar -->
    <!-- sidebar -->
    @include('_partials.admin.sidebar', ['items' => [
        [
            'name' => 'Terug naar website',
            'icon' => 'fa fa-hand-point-left',
            'href' => '/'
        ],
        [
            'name' => 'Dasboard',
            'icon' => 'fa fa-home',
            'href' => '/admin'
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

        const autoCompleteJS = new autoComplete({
            selector: "#autoComplete",
            placeHolder: "Search...",
            data: {
                src: async () => {
                    const source = await fetch("/admin/search/auto?q=" + $('#autoComplete').val());
                    return await source.json();
                },
                key: ["text"],
                cache: false
            },
            onSelection: (feedback) => {
                window.location.href = feedback.selection.value.url;
            },
            resultsList: {
                noResults: (list, query) => {
                    const message = document.createElement("li");
                    message.setAttribute("class", "no_result autoComplete_result");
                    message.innerHTML = `<span>Press enter to search for "${query}"</span>`;
                    list.appendChild(message);
                },
            },
            resultItem: {
                highlight: {
                    render: true
                }
            }
        });

        $(document).on('keydown', '#autoComplete', function(e) {
            if(e.keyCode === 13) {
                window.location.href = '/admin/search/full?q=' + $(this).val()
            }
        })
    </script>
    @stack('scripts')
</body>
</html>
