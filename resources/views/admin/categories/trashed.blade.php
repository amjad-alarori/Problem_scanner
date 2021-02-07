@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
            @if($categories->count() == 0)
                    <p style="text-align:center;margin:20vh auto; font-size:20px;">Er zitten momenteel nog geen categorieën in de prullenbak <br><br> Ga <a href="{{route('categories.index')}}">Hier</a> naar het overzicht van alle huidige categorieën. </p>

            @else
                <ul class="list group">
                @foreach($categories as $category)
                    <li class="list-group-item">
                        <form action="{{route('categories.updateTrashed',['id'=>$scan])}}" method="POST" class="mb-3">
                            @csrf                 <p style="font-size:18">Categorie:   {{$category->name}}   <button type="submit" class="btn btn-success float-right" >Zet weer actief</button></p>


                        </form>
                    </li>
                @endforeach
                </ul>
            @endif

    </div>
    <div style="margin:0 auto; display: block; width:50px; padding:0;">
        {{ $categories->links("pagination::bootstrap-4") }}
    </div>
@endsection
