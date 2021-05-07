@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        @if(Auth::user()->isAdmin())
            <form action="{{route('scan.store')}}" method="post" class="form-group">
                @csrf
                <div class="form-group">
                    <label>Maak een scan aan</label>
                    <input type="text" name="name" class="form-control" placeholder="Scan naam">
                </div>
                <p class="mb-0">
                    <a class="text-muted" data-toggle="collapse" href="#collapseExample" role="button">
                        Geavanceerd <i class="fa fa-cog"></i>
                    </a>
                </p>
                <div class="collapse mb-4" id="collapseExample">
                    <div class="card card-body">
                        <x-language-form name="name"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-orange">
                    {{__('buttons.primary')}}
                </button>
            </form>
            <hr>
        @endif
        @if($scans->count() == 0)
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <p>Er zijn momenteel nog geen scans aangemaakt</p>
                            @if(Auth::user()->isAdmin()) <p>Maak hierboven een scan aan</p>@endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            @foreach($scans as $scan)
                <div class="row mt-2">
                    <div class="col">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between">
                                {{$scan->__name ?? "Scan"}}
                                <a href="{{route('scan.show',$scan)}}" class="btn btn-orange">View scan</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
