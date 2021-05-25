@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <a href="{{route('consulent.create')}}" class="btn btn-orange">Create client</a>

        @if(!count($clients) >0)
            <p style="text-align:center;">U heeft nog momenteel geen clienten. <br><br>Clienten kunnen u toevoegen doormiddel van uw E-mail adress in hun accounts.</p>
        @else
            <ul class="list-group mt-5">

                @foreach($clients as $status=>$clienten)

                    @if($status == "verified")
                        <p>geverifieerde clienten</p>
                        @foreach($clienten as $client)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-9">
                                        <form action="{{route('consulent.show',$client)}}" method="get">@csrf
                                            <div class="row">
                                                <div class="col-9"><p class="pr-5">{{$client->name}} | {{$client->email}}</p></div>
                                                <div class="col-3">
                                                    <button type="submit" class="btn btn-orange float-right">bekijk
                                                        client
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-3">
                                        <form action="{{route('consulent.remove')}}" method="post"> @method('POST') @csrf
                                            <input type="hidden" name="client" value="{{$client->id}}">
                                            <button type="submit" class="btn btn-danger float-right">Verwijder client
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif

                    @if($status == "unverified")
                        <p class="mt-3">Nog niet geverifieërd</p>
                        @foreach($clienten as $client)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-9">
                                        <form action="{{route('consulent.show',$client)}}" method="get">@csrf
                                            <div class="row">
                                                <div class="col-9"><p class="pr-5">{{$client->name}} | {{$client->email}}</p></div>
                                                <div class="col-3">
                                                    {{--                                                    <button type="submit" class="btn btn-orange float-right">bekijk--}}
                                                    {{--                                                        client--}}
                                                    {{--                                                    </button>--}}
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-3">
                                        <form action="{{route('consulent.accept')}}" method="post"> @method('POST') @csrf
                                            <input type="hidden" name="client" value="{{$client->id}}">
                                            <button type="submit" class="btn btn-success float-right">Accepteer client
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
            <ul class="list-group">

                @foreach($clients as $status=>$clienten)
                    @if($status == "trashed")
                        <p class="mt-3">Verwijderde clienten</p>
                        @foreach($clienten as $client)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-9">
                                        <form action="{{route('consulent.show',$client)}}" method="get">@csrf
                                            <div class="row">
                                                <div class="col-9"><p class="pr-5">{{$client->name}} | {{$client->email}}</p></div>
                                                <div class="col-3">
                                                    {{--                                                    <button type="submit" class="btn btn-orange float-right">bekijk--}}
                                                    {{--                                                        client--}}
                                                    {{--                                                    </button>--}}
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-3">
                                        <form action="{{route('consulent.recover')}}" method="post"> @method('POST') @csrf
                                            <input type="hidden" name="client" value="{{$client->id}}">
                                            <button type="submit" class="btn btn-success float-right">Herstel client
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        @endif

    </div>
@endsection
