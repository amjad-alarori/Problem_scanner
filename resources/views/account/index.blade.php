@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="  @if(Auth::user()->roles[0]->level <= 1) col-6 @else col-12 @endif">
                <h1 style="text-align: center;">Account overzicht</h1>
                <div class="card" style="width: 25rem; margin:0 auto;display: block;">
                    <div class="card-body">
                        <i class="fa fa-user fa-6x" aria-hidden="true"
                           style="margin: 0 auto; display: block; width:30%;"></i>
                        <p class="card-text">
                            <br>
                            Naam : {{$user->name}}
                            <br>
                            Email : {{$user->email}}
                        </p> @if($result != null)
                            <a href="{{route('export.show',$result)}}" class="card-link">Gemaakte scans</a>
                        @endif
                    </div>
                </div>
            </div>
            @if(Auth::user()->roles[0]->level <= 1)
            <div class="col-6">
                <h1 style="text-align: center;">Consulent toevoegen</h1>
                <div class="card" style="width: 25rem; margin:0 auto;display: block;">
                    <div class="card-body">
                        <i class="fa fa-address-card fa-6x" aria-hidden="true"
                           style="margin: 0 auto; display: block; width:30%;"></i>
                        <form id="form" action="{{route('consulent.add')}}" class="mt-4" method="post">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <input class="form-control  mb-3 pb-2" type="email" name="consulent" placeholder="name@example.com"  required>
                            <a class="card-link pt-3" id="add">Voeg toe</a>
                        </form>     @if (Session::has('success'))
                            <div class="alert alert-success mt-2">{{ Session::get('success') }}</div>
                        @endif
                    </div>
                </div>
            </div>
                @endif
        </div>

    </div>


@endsection
@push('scripts')
    <script>
        document.getElementById("add").onclick = function() {
            document.getElementById("form").submit();
        }
    </script>
    @endpush
