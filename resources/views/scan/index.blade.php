@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        @if(Auth::user()->isAdmin())
            <form action="{{route('scan.store')}}" method="post" class="form-group">
                @csrf
                <label>
                    Scan naam:
                    <input type="text" name="name" class="form-control">
                </label>

                <button type="submit" class="btn btn-primary">
                    {{__('buttons.primary')}}
                </button>
            </form>
        @endif
        <ul class="list group">
            @if($scans->count() == 0)
                <li class="list-group-item">
                    <p>Er zijn momenteel nog geen scans aangemaakt</p>
                    @if(Auth::user()->isAdmin()) <p>Maak hierboven een scan aan</p>@endif
                </li>
            @else
                @foreach($scans as $scan)
                    <li class="list-group-item">
                        {{$scan->name}}
                        <form action="{{route('scan.show',$scan)}}" method="get">
                            <button type="submit" class="btn btn-primary">View scan</button>
                        </form>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection
