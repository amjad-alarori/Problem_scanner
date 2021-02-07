@extends('layouts.admin')

@section('content')
    <div class="container mt-5 ">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <h1>Gebruikers rollen</h1>
        <div class="card">
            <div class="card-header">Rollen</div>
            <div class="container">
                <div class="card-body" style="width:100%;">
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="mb-3">
                        <h3>Maak hier je rol aan</h3>
                        <form class="form-inline" method="post" action="{{route('roles.store')}}">
                            @csrf
                            <input type="text" class="form-control" name="name" placeholder="Naam" style="width:185px;">
                            <input type="text" class="form-control" name="slug" placeholder="Slug" style="width:178px;">
                            <input type="text" class="form-control" name="description" placeholder="Omschrijving"
                                   style="width:250px;">
                            <input type="text" class="form-control" name="level" placeholder="level"
                                   style="width:120px">
                            <button type="submit" class="btn btn-primary">Maak nieuwe rol aan</button>
                        </form>
                    </div>
                    <div class="mb-5">
                        <h3>Rollen overzicht</h3>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Slug</th>
                                <th>Omschrijving</th>
                                <th>Level</th>
                                <th>Acties</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->slug}}</td>
                                    <td>{{$role->description}}</td>
                                    <td>{{$role->level}}</td>
                                    <td>
                                        <form action="{{route('roles.destroy',$role)}}"
                                              method="post">@method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash fa-xs"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
