@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1 style="text-align: center;">Account overzicht</h1>
        <div class="card" style="width: 25rem; margin:0 auto;display: block;">
            <div class="card-body">
                <i class="fa fa-user fa-6x" aria-hidden="true" style="margin: 0 auto; display: block; width:30%;"></i>

                {{--                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>--}}
                <p class="card-text">

                    <br>

                    Naam : {{$user->name}}
                    <br>
                    Email / Gebruikersnaam : {{$user->email}}
                    <br>
                @if ($showPasswordUpdate)
                    <form action="{{route('consulent.updatePassword')}}" method="post"> @method('POST') @csrf
                        <input type="hidden" name="userId" value="{{$user->id}}">
                        Nieuw wachtwoord: <input type="password" name="newPassword">
                    </form>
                    @endif


                    </p>  @if($results != null)
                        <a href="{{route('export.show',$results)}}" class="card-link">Gemaakte scans</a>
                    @else
                        <p>Deze client heeft nog geen scan gemaakt.</p>
                    @endif
            </div>
        </div>

    </div>


@endsection
