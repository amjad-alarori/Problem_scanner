@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        @if(request()->get('success'))
            <div class="alert alert-success">
                Saved changes
            </div>
        @endif
        <form action="/admin/emailtranslation/config/update" method="post">
            <div class="d-flex justify-content-between">
                <h1>Edit email config</h1>
                <div class="p-2 pr-2">
                    <button type="submit" class="btn btn-sm btn-success d-block"><i
                            class="fa fa-save"></i></button>
                </div>
            </div>
            @csrf
            <div class="card">
                <div class="card-body">
                    @foreach($possibleConfigs as $key => $value)
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">{{$key}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="{{$key}}" placeholder="{{$key}}"
                                       value="{{$configs->where('key', $key)->first()->value ?? $value}}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
@endsection
