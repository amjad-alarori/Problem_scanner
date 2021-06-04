@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Edit category</h4>
                <form action="{{route('categories.destroy',['category'=>$category->id])}}"
                      method="post">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">{{__('buttons.delete')}}</button>
                </form>
            </div>
            {{ Form::open(array('route' => array('categories.update',['category'=>$category->id]),'method'=>'put','files'=>true)) }}
            <div class="card-body">
                <div class="form-group">
                    <label>Category name</label>
                    {{ Form::text('category',$category->name,array('class'=>'form-control mb-3')) }}
                </div>
                <div class="form-group">
                    <label>Belongs to scan</label>
                    {{ Form::select('scan',$scans,$category->scan_id,array('class'=>'form-control mb-3')) }}
                </div>
                <div class="form-group">
                    <label>Graph color</label>
                    <input class="form-control" type="color" name="color" value="{{$category->color}}" required>
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
                        <x-language-form name="name" values="{{$category->getTranslationDataForEdit('name')}}"/>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{Form::submit(__('buttons.update'),array('class'=>'btn btn-orange'))}}
                <a href="{{route('categories.index')}}" class="btn btn-warning">Cancel</a>
            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection


