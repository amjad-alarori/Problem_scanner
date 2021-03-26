@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <form action="{{route('emailtranslation.update', ['emailtranslation' => $emailtranslation->id])}}"
              method="post">
            @method('put')
            @if(request()->get('exists'))
                <div class="alert alert-info">
                    Email already exists. We have brought you to the email
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <h1>Edit email</h1>
                <div class="p-2 pr-2 d-flex justify-content-between">
                    @if($emailtranslation->language !== \App\Helpers\LanguageHelper::$DEFAULT_LANGUAGE)
                        <div class="mr-4">
                            <a type="button"
                               data-url="{{route('emailtranslation.destroy', ['emailtranslation' => $emailtranslation->id])}}"
                               class="btn btn-sm btn-danger confirm d-block"><i
                                    class="fa fa-trash"></i></a>
                        </div>
                    @endif
                    <div class="mr-2">
                        <a type="button" data-toggle="modal" data-target="#exampleModal"
                           class="btn btn-sm btn-info d-block"><i
                                class="fa fa-percentage"></i></a>
                    </div>
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
                                <p>{{$emailtranslation->type}}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Language</label>
                                <p>{{\App\Helpers\LanguageHelper::IsoToName($emailtranslation->language)}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" class="form-control" name="subject" required
                               value="{{$emailtranslation->subject}}">
                    </div>
                    <div class="form-group mt-2">
                        <label>Body</label>
                        <x-summernote name="body" required value="{{$emailtranslation->body}}"/>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Variables</h5>
                        <p type="button" class="fa fa-question"
                           data-html="true" data-toggle="tooltip" data-placement="right"
                           title="<small class='text-muted'>Variables are dynamic values. Those values are filled in by the system when the mail is send.</small><br><small class='text-muted'>Example: </small><small class='text-muted'><b>%USER_NAME%</b> will become <b>{{auth()->user()->name}}</b></small>">
                        </p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="w-100">
                            <thead>
                            <tr>
                                <td>Variable</td>
                                <td>Definition</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($variables as $var => $desc)
                                <tr>
                                    <td>%{{$var}}%</td>
                                    <td>{{$desc}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <script>
                            $('[data-toggle="tooltip"]').tooltip()
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
