@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <form action="{{route('emailcomponenttranslation.update', ['emailcomponenttranslation' => $emailcomponenttranslation->id])}}"
              method="post">
            @method('put')
            @if(request()->get('exists'))
                <div class="alert alert-info">
                    Component already exists. We have brought you to the component
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <h1>Edit email</h1>
                <div class="p-2 pr-2 d-flex justify-content-between">
                    @if($emailcomponenttranslation->language !== \App\Helpers\LanguageHelper::$DEFAULT_LANGUAGE)
                        <div class="mr-4">
                            <a type="button"
                               data-url="{{route('emailcomponenttranslation.destroy', ['emailcomponenttranslation' => $emailcomponenttranslation->id])}}"
                               class="btn btn-sm btn-danger confirm d-block"><i
                                    class="fa fa-trash"></i></a>
                        </div>
                    @endif
                    <div>
                        <button type="submit" class="btn btn-sm btn-success d-block"><i
                                class="fa fa-save"></i></button>
                    </div>
                </div>
            </div>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Type</label>
                                <p>{{$emailcomponenttranslation->type}}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Language</label>
                                <p>{{\App\Helpers\LanguageHelper::IsoToName($emailcomponenttranslation->language)}}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="form-group">
                        <label>Text</label>
                        <input type="text" class="form-control" name="text" required
                               value="{{$emailcomponenttranslation->text}}">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
