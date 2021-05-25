@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Creëer client</div>
            <form action="{{route('consulent.store')}}" method="post">
                <div class="card-body">
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    @csrf
                    <div class="form-group">
                        <label>Naam</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email / Gebruikersnaam</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-orange">Maak aan</button>
                    <a href="/consulent" class="btn btn-warning">Annuleer</a>
                </div>
            </form>
        </div>
    </div>
@endsection
