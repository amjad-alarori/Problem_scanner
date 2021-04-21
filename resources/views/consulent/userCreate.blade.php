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
</head>
<body>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <a href="{{route('consulent.index')}}" class="btn btn-primary">Terug naar overzicht</a>
            <div class="card">
                <div class="card-header">Users</div>
                <div class="container">
                    <div class="card-body" style="width:100%;">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form action="{{route('consulent.store')}}" method="post">
                                    @csrf
                                    <td>
                                        <label>
                                            <input type="text" name="name" class="form-control" required>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="email" name="email" class="form-control" required>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </label>
                                    </td>
                                </form>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@push('scripts')
    <script>
        function submitform(id) {
            $('#changeForm' + id).submit();
        }

    </script>
@endpush
