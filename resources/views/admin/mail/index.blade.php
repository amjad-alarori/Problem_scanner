@extends('layouts.admin')
@section('content')
<h1>Mail schrijven naar klanten</h1>


<form action="">

    <div class="form-group">
        <label for="subject">Hier kunt u het onderwerp vermelden</label>
{{--       x = declares a component -summernote is name of our blade file --}}
        <x-summernote name="subject"/>
        <label for="body">Hier kunt u de inleiding in vermelden</label>
        <x-summernote name="body"/>
    </div>
    <a href="#" type="submit" class="btn btn-primary" >Verstuur</a>
</form>

@endsection
