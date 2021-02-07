@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width:10%;">#</th>
                <th scope="col" style="width:80%;">Vraag</th>
                <th scope="col" style="width:10%;">geselecteerd</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $key=>$value)
                <tr>
                    <th scope="row">{{$key}}</th>
                    @foreach($value as $key2=>$value2)
                        <td>{{$key2}}</td>
                        <td>{{$value2}}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <form method="post" action="{{route('export.store')}}">@csrf<button type="submit" class="btn btn-primary">exporteer naar pdf</button><input type="hidden" name="id" value="{{$result->id}}"></form>
    </div>
@endsection
