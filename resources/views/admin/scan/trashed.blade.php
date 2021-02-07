@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
            @if($scans->count() == 0)
                    <p style="text-align:center;margin:20vh auto; font-size:20px;">Er zitten momenteel nog geen scans in de prullenbak <br><br> Ga <a href="{{route('scan.index')}}">Hier</a> naar het overzicht van alle huidige scans. </p>

            @else
                <ul class="list group">
                @foreach($scans as $scan)
                    <li class="list-group-item">
                        <form action="{{route('scan.updateTrashed',['id'=>$scan])}}" method="POST" class="mb-3">
                            @csrf               <p style="font-size:18">Scan:   {{$scan->name}}   <button type="submit" class="btn btn-success float-right" >Zet weer actief</button></p>


                        </form>
                    </li>
                @endforeach
                </ul>
            @endif

    </div>
    <div style="margin:0 auto; display: block; width:50px; padding:0;">
        {{ $scans->links("pagination::bootstrap-4") }}
    </div>
@endsection
