@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        {{ Form::open(array('route' => array('categories.store'),'method'=>'post','files'=>true)) }}
        <div class="card">
            <div class="card-header">Create category</div>
            <div class="card-body">
                <div class="form-group">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                    <div class="form-group">
                        <label>Category name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Belongs to scan</label>
                        <select name="scan_id" class="form-control">
                            @if(count($scans))
                                @foreach($scans as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Graph color</label>
                        <input class="form-control" type="color" name="color" required>
                    </div>
                    <div class="form-group">
                        <label>Picture</label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input name="image" type="file" class="custom-file-input" id="inputGroupFile01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <p>
                        <a class="text-muted" data-toggle="collapse" href="#collapseExample" role="button">
                            Geavanceerd <i class="fa fa-cog"></i>
                        </a>
                    </p>
                    <div class="collapse mb-4" id="collapseExample">
                        <div class="card card-body">
                            <x-language-form name="name"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{Form::submit(__('buttons.primary'),array('class'=>'btn btn-primary'))}}
                <a href="{{route('categories.index')}}" class="btn btn-warning">Cancel</a>
            </div>
        </div>
        {{Form::close()}}

    </div>
@endsection
