@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        @if(request()->get('delete'))
            <div class="alert alert-warning">
                You are not allowed to delete a Dutch (nl_NL) email
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h1>Email translations</h1>
            <div class="p-2 pr-2">
                <a type="button" class="btn btn-sm btn-info d-block" data-toggle="modal"
                   data-target="#exampleModal"><i
                        class="fa fa-plus"></i></a>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
                <form action="{{route('emailtranslation.store')}}" method="post">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add translation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control" required>
                                        @foreach(\App\Helpers\EmailHelper::GetAllPossibleEmailTranslations() as $posibleTemplate)
                                            <option value="{{$posibleTemplate}}">{{$posibleTemplate}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Language</label>
                                    <select class="select2" name="language" required>
                                        @foreach(\App\Helpers\LanguageHelper::$allLanguageIsos as $name => $iso)
                                            <option
                                                @if($iso === \App\Helpers\LanguageHelper::$DEFAULT_LANGUAGE) selected
                                                @endif value="{{$iso}}">{{$name}}
                                                - {{$iso}}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        $('.select2').select2({
                                            dropdownParent: $("#exampleModal"),
                                            maximumSelectionSize: 1
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">Email type</div>
                    <div class="col-3">Translations</div>
                    <div class="col-3">About</div>
                    <div class="col-2 text-right">Tools</div>
                </div>
                <hr class="mt-0">
                @if(count($emailTranslations))
                    @foreach($emailTranslations as $name => $et)
                        <div class="row">
                            <div class="col-4">{{$name}}</div>
                            <div class="col-3">{{count($et)}}</div>
                            <div class="col-3"><span data-tooltip="tooltip" data-placement="left" class="cursor-help"
                                                     data-title="{{\App\Helpers\EmailHelper::GetEmailDescription($name)}}"><i
                                        class="fa fa-question-circle"></i></span></div>
                            <div class="col-2 text-right">
                                <a data-toggle="collapse" href="#collapse{{$loop->index}}" role="button"><i
                                        class="fa fa-chevron-right toggleclass" toggle-class="r90"></i></a>
                            </div>
                            <div class="collapse m-2 w-100" id="collapse{{$loop->index}}">
                                <div class="card card-body">
                                    @foreach($et as $e)
                                        <div class="row">
                                            <div
                                                class="col-5">{{\App\Helpers\LanguageHelper::IsoToName($e->language)}}</div>
                                            <div class="col-5">Updated {{$e->updated_at->diffForHumans()}}</div>
                                            <div class="col-2 text-right">
                                                <a target="_blank"
                                                   href="{{route('emailtranslation.preview', ['emailtranslation' => $e->id])}}"
                                                   class="mr-2"><i class="fa fa-eye"></i></a>
                                                <a href="{{route('emailtranslation.edit', ['emailtranslation' => $e->id])}}"><i
                                                        class="fa fa-pencil-alt"></i></a>
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @else
                    <p class="mb-0">No translations found</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        $('[data-tooltip="tooltip"]').tooltip()
    </script>
@endsection
