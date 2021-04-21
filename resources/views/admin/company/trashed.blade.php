@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
            @if($users->count() == 0)
                    <p style="text-align:center;margin:20vh auto; font-size:20px;">Er zitten momenteel nog geen gebruikers in de prullenbak <br><br> Ga <a href="{{route('user.index')}}">Hier</a> naar het overzicht van alle huidige gebruikers. </p>

            @else
                <ul class="list group">
                @foreach($users as $user)
                    <li class="list-group-item">
                        <form action="{{route('user.updateTrashed',['id'=>$user])}}" method="POST" class="mb-3">
                            @csrf               <p style="font-size:18">Gebruiker:   {{$user->name}}   <button type="submit" class="btn btn-success float-right" >Zet weer actief</button></p>


                        </form>
                    </li>
                @endforeach
                </ul>
            @endif

    </div>
    <div style="margin:0 auto; display: block; width:50px; padding:0;">
        {{ $users->links("pagination::bootstrap-4") }}
    </div>
@endsection
