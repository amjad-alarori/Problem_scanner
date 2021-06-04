@extends('layouts.admin')

@section('content')

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Edit question</h4>
                <div>
                    <form action="{{route('questions.destroy', ['question' => $question->id])}}" method="post">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">{{__('buttons.delete')}}</button>
                    </form>
                </div>
            </div>
            {{ Form::open(array('route' => array('questions.update',['question'=>$question->id]),'method'=>'put','files'=>true)) }}
            <div class="card-body">
                <div class="form-group">
                    <label>Vraag</label>
                    {{ Form::text('question',$question->question,array('class'=>'form-control')) }}
                </div>
                <div class="form-group">
                    <label>Goort bij categorie</label>
                    {{Form::select('category',$categories,$question->categories_id,array('class'=>'form-control'))}}
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
                        <x-language-form name="language" values="{{$question->getTranslationDataForEdit('question')}}"/>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{Form::submit(__('buttons.update'),array('class'=>'btn btn-primary'))}}
                <a class="btn btn-warning" href="{{route('questions.index')}}">Cancel</a>
            </div>
            {{Form::close()}}
        </div>
    </div>

@endsection
