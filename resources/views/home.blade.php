@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">{{__('greetings.welcome')}} {{Auth::user()->name}}</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 p-3">
                <div class="card">
                    <div class="card-body bg-tile text-tile rounded">
                        <h2 class="mb-0"><i class="fas fa-calendar-alt"></i>&nbsp; {{date("d-m-Y",strtotime("l"))}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 p-3">
                <div class="card">
                    <div class="card-body bg-tile text-tile rounded">
                        <h2 class="mb-0">{{__('scans.scans_made')}} {{$scansMade}}    </h2>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 p-3">
                <div class="tile d-flex justify-content-center align-items-center text-white rounded w-100">

                    <div class="text">
                        <h1 class="animate-title text-center"><i class="fas fa-eye"></i>&nbsp;{{__('scans.start_scan')}}</h1>
                        <a class="stretched-link" href="{{route('scan.index')}}"></a>

                        <p class="animate-text">{{__('scans.start_scan_block_message')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 p-3">
                <div class="tile d-flex justify-content-center align-items-center text-white rounded w-100">
                    <div class="text">
                        <h1 class="animate-title"><i class="fas fa-chart-line"></i>&nbsp;{{__('scans.results')}}</h1>
                        <a class="stretched-link" href="{{route('results.index')}}"></a>
                        <p class="animate-text">{{__('scans.results_block_message')}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--        <div class="row justify-content-center pt-5">--}}

    {{--            @if(!Auth::user())--}}
    {{--                <p class="pt-5"> Log in om de scan af te nemen.<br> nog geen login? registreer <a--}}
    {{--                        href="/register">hier.</a></p>--}}
    {{--            @else--}}
    {{--                <p class="pt-5"> Klik de knop om een scan af te nemen <br><br><a class="btn btn-primary text-center" href="/scan">Neem scan af.</a></p>--}}

    {{--            @endguest--}}


    {{--        </div>--}}

@endsection
