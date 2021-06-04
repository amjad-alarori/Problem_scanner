@extends('layouts.admin')

@section('content')

    <div class="container mt-5">
        {{ Form::open(array('route' => array('questions.store'),'method'=>'post','files'=>true)) }}
        <div class="card">
            <div class="card-header">Create question</div>
            <div class="card-body">
                <div class="form-group">
                    <label>Vraag</label>
                    <input type="text" class="form-control" name="question">
                </div>
                <div class="form-group">
                    <label>Hoort bij categorie</label>
                    <select name="categories_id" class="form-control">
                        @if(count($categories))
                            @foreach($categories as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        @endif
                    </select>
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
                <p class="mb-0">
                    <a class="text-muted" data-toggle="collapse" href="#collapseExample" role="button">
                        Geavanceerd <i class="fa fa-cog"></i>
                    </a>
                </p>
                <div class="collapse mb-4" id="collapseExample">
                    <div class="card card-body">
                        <x-language-form name="question"/>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{Form::submit(__('buttons.create'),array('class'=>'btn btn-primary'))}}
                <a href="{{route('questions.index')}}" class="btn btn-warning">Cancel</a>
            </div>
        </div>
        {{Form::close()}}
    </div>

@endsection
