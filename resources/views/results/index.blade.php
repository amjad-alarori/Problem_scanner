@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="list-group mt-5">
            @if(count($results) <=0)
                <p style="text-align:center;">Er zijn nog geen scans gemaakt</p>
                <a href="/scan" style="text-align:center;">Maak hier een scan</a>
            @else
                @foreach($results as $result)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="pr-5 mb-0">{{$result->name}} @if(Auth::user()->roles[0]->level == 2) {{$result->user->email}} @endif</h5>
                            </div>
                            <div class="col-6">
                                <a href="{{route('export.show',$result)}}"
                                   class="btn btn-orange float-right">{{__('scans.show_results')}}
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection
