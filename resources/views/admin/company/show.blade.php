@extends('layouts.admin')
@section('content')
@foreach($user as $item)
    {{$item->name}}
@endforeach
    @endsection
