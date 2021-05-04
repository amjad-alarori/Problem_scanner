@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h3>Categories</h3>
            <a href="{{route('categories.create')}}" class="btn btn-orange">Create</a>
        </div>
        <hr>
        @if(count($categories))
        <div class="list-group">
            @foreach($categories as $category)
                <div class="list-group-item d-flex justify-content-between">
                    <div>
                        {{$category->name}}
                        <br>
                        <a href="{{route('categories.edit', ['category' => $category->id])}}">Bewerk <i
                                class="fa fa-edit"></i></a>
                    </div>
                    <img src="{{$category->image}}" style="height:40px;">
                </div>
            @endforeach
        </div>
        @else
            <p>Geen categorieën gevonden</p>
        @endif
    </div>
@endsection
