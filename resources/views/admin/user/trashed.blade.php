@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @elseif(Session::has('failed'))
            <div class="alert alert-success">{{ Session::get('failed') }}</div>
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
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal{{$user->id}}">
                            Hard delete
                        </button>

                        <!-- Modal -->
                        <div class="modal" id="modal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        weet u het zeker? dit kan niet meer ongedaan worden
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form action="{{route('user.hardDelete',['id'=>$user])}}" method="POST" class="mb-3">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">hard delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            @endif

    </div>
    <div style="margin:0 auto; display: block; width:50px; padding:0;">
        {{ $users->links("pagination::bootstrap-4") }}
    </div>
@endsection
