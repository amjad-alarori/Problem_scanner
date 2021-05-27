@extends('layouts.admin')@section('content')
    <main role="main" class="container font-sans text-gray-900 antialiased">
        @if(session()->has('NoAccess') || session()->has('showError'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible m-3" id="noaccess-error">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session()->has('NoAccess')?session('NoAccess'):session('showError')}}
                </div>
            </div>
        @endif
        <div class="container-fluid pt-9 h-100 pb-3">
            @yield('content')
        </div>
    </main>
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h1>Translations {{$languages->name}}</h1>
            <div class="p-2 pr-2">
                <a type="button" class="btn btn-sm btn-info d-block" data-toggle="modal"
                   data-target="#exampleModal"><i
                        class="fa fa-plus"></i></a>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
                <form action="{{route('translations.store', ['languages'=>$languages])}}" method="post">
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
                                    <label for="group-input" class="col-form-label">Group</label>
                                    <input type="text" name="group" id="group-input" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="key-input" class="col-form-label">Key</label>
                                    <select name="key" class="select2 form-control">
                                        @foreach($keys as $key)
                                            <option value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        $('.select2').select2({
                                            dropdownParent: $("#exampleModal"),
                                            maximumSelectionSize: 1
                                        });
                                    </script>
                                    {{--                                    <input type="text" name="key" id="key-input" class="select2" required>--}}
                                </div>
                                <div class="form-group mt-2">
                                    <label for="translation-input" class="col-form-label">Translation</label>
                                    <input type="text" name="translation" id="translation-input" class="form-control"
                                           required>
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
                    <div class="col-3">Group</div>
                    <div class="col-3">Key</div>
                    <div class="col-4">Translation</div>
                    <div class="col-2">Actions</div>
                </div>
                <hr class="mt-0">
                @if(count($translations))
                    @foreach($translations as $translation)
                        <div class="row">
                            <div class="col-3">{{($translation->group)}}</div>
                            <div class="col-3">{{$translation->key}}</div>
                            <div class="col-4">{{$translation->translation}}</div>
                            <div class="col-0.75">
                                <button class="btn btn-warning" type="button" data-toggle="modal"
                                        data-target="#editModal-{{$translation->id}}"><i class="fas fa-pen-square"></i>
                                </button>
                                <div class="modal fade" id="editModal-{{$translation->id}}" tabindex="-1" role="dialog">
                                    <form
                                        action="{{route('translations.update', ['languages' => $languages, 'translation' => $translation->id])}}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit translation</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mt-2">
                                                        <label for="group-input" class="col-form-label">Group</label>
                                                        <input type="text" name="group" id="group-input"
                                                               class="form-control" value="{{$translation->group}}"
                                                               required>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="key-input" class="col-form-label">Key</label>
                                                        <input type="text" name="key" id="key-input"
                                                               class="form-control" value="{{$translation->key}}"
                                                               readonly>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="translation-input" class="col-form-label">Translation</label>
                                                        <input type="text" name="translation" id="translation-input"
                                                               class="form-control"
                                                               value="{{$translation->translation}}" required>
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
                                <form
                                    action="{{route('translations.destroy', ['languages' => $languages, 'translation' => $translation->id])}}"
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
                    <p class="mb-0 alert-danger">{{strtoupper('no translations created yet')}}</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        $('[data-tooltip="tooltip"]').tooltip()
    </script>
    <script>
        $(function () {
            $("#noaccess-error").delay(4000).slideUp(800, function () {
                $(this).remove();
            });
        });
    </script>
@endsection
