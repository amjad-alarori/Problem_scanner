@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        {{ Form::open(array('route' => array('questions.store'),'method'=>'post','files'=>true)) }}
        <div class="form-group">
            Vraag:
            {{ Form::text('question',null,array('class'=>'form-control mb-3')) }}
            Hoort bij categorie:
            {{Form::select('category',$categories,null,array('class'=>'form-control mb-3'))}}
            Foto:
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">       {{Form::file('image')}}

                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
        </div>
        {{Form::submit(__('buttons.primary'),array('class'=>'btn btn-primary'))}}
        {{Form::close()}}
        <div class="mt-5">
            <h3>Questions:</h3>
        </div>
        <div class="list-group">

            @foreach($questions as $question)
                <a class="list-group-item list-group-item-action" data-toggle="collapse"
                   href="#{{'collapse'.$question->id}}" role="button" aria-expanded="false"
                   aria-controls="{{'collapse'.$question->id}}">{{$question->question}}<img
                        src="{{$question->image}}" class="float-right" style="height:40px;"></img></a>
                <div class="collapse" id="{{'collapse'.$question->id}}">
                    <div class="p-5" id="{{'collapseEdit'.$question->id}}">
                        {{ Form::open(array('route' => array('questions.update',['question'=>$question->id]),'method'=>'put','files'=>true)) }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Question: </label> {{ Form::text('question',$question->question,array('class'=>'form-control')) }}
                                </div>
                                <div class="col-md-6">
                                    <label>Category: </label> {{Form::select('category',$categories,$question->categories_id,array('class'=>'form-control'))}}
                                </div>
                            </div>

                            <div class="input-group mt-3 mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">       {{Form::file('image')}}

                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-md-6"> {{Form::submit(__('buttons.warning'),array('class'=>'btn btn-warning'))}}
                                {{Form::close()}}</div>
                            <div class="col-md-6">
                                <form action="{{route('questions.destroy',['question'=>$question->id])}}"
                                      method="post">@csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger float-right">{{__('buttons.danger')}}</button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('input[type=file]').addClass('custom-file-input')
    </script>
@endpush

