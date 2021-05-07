@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="list-group mt-5">

            @if(count($results) <=0)
                <p style="text-align:center;">Er zijn nog geen scans gemaakt</p>
                <a href="/scan" style="text-align:center;">Maak hier een scan</a>
            @else
                @if(Auth::user()->roles[0]->level == 2)
                    @foreach($results as $result)
                        <li class="list-group-item">
                            <form action="{{route('export.show',$result)}}" method="get">@csrf
                                <div class="row">
                                    <div class="col-6"><h5 class="pr-5">{{$result->name }} {{\App\Models\User::find($result->user_id)->email}}</h5></div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-orange float-right">bekijk resultaten
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    @endforeach
                        @else
                            @foreach($results as $result)
                                <li class="list-group-item">
                                    <form action="{{route('export.show',$result)}}" method="get">@csrf
                                        <div class="row">
                                            <div class="col-6"><h3 class="pr-5">{{$result->scan}}</h3></div>
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-orange float-right">bekijk
                                                    resultaten
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            @endforeach
                        @endif
                        @endif
        </ul>

    </div>
@endsection
