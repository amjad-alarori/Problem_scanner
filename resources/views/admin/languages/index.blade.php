@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h1>Translatable Languages</h1>
            <div class="p-2 pr-2">
                <a type="button" class="btn btn-sm btn-info d-block" data-toggle="modal"
                   data-target="#exampleModal"><i
                        class="fa fa-plus"></i></a>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
                <form action="{{route('languages.store')}}" method="post">
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
                                <div class="form-group mt-2">
                                    <label class="col-form-label">Name</label>
                                    <input type="text" class="form-control" name="name" required>
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
                    <div class="col-4">Name</div>
                    <div class="col-2">Iso</div>
                    <div class="col-4">Go to translations</div>
                    <div class="col-2">Actions</div>
                </div>
                <hr class="mt-0">

                @if(count($languages))
                    @foreach($languages as $language)
                        <div class="row">
                            <div class="col-4">{{$language->name}}</div>
                            <div class="col-2">{{strtoupper($language->language)}}</div>
                            <div class="col-4">
                                <a href="{{route('translations.index', ['languages' => $language->id])}}" class=""><i class="fas fa-list-ul"></i></a>
                            </div>
                            <div class="col-0.75">
                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#editModal-{{$language->id}}"><i class="fas fa-pen-square"></i></button>
                                <div class="modal fade" id="editModal-{{$language->id}}" tabindex="-1" role="dialog">
                                    <form action="{{route('languages.update', ['language' => $language->id])}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModal">Edit translation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mt-2">
                                                        <label for="group-input" class="col-form-label">Group</label>
                                                        <input type="text" name="name" id="group-input"
                                                               class="form-control" value="{{$language->name}}">
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="key-input" class="col-form-label">Key</label>
                                                        <input type="text" name="language" id="key-input"
                                                               class="form-control" value="{{$language->language}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-1">
                                <form action="{{route('languages.destroy', ['language' => $language->id])}}"
                                      method="post">@method('DELETE') @csrf
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fa fa-trash fa-xs"></i></button>
                                </form>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @else
                    <p class="mb-0">no languages created yet</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        $('[data-tooltip="tooltip"]').tooltip()
    </script>
@endsection
