@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <a class="nav-link active" id="v-pills-home-personal" data-toggle="pill" href="#v-personal"
                       role="tab">Account
                        overzicht</a>
{{--                    @if(Auth::user()->roles[0]->level <= 1)--}}
{{--                        <a class="nav-link" id="v-pills-home-consulent" data-toggle="pill" href="#v-consulent"--}}
{{--                           role="tab">Consulenten</a>--}}
{{--                    @endif--}}
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-personal" role="tabpanel">
                        <form action="{{route("account.update", ['account' => auth()->user()->id])}}" method="post">
                            @method('put')
                            @csrf
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    Account overzicht
                                    @if($result != null)
                                        <a href="{{route('export.show',$result)}}" class="card-link">Gemaakte scans</a>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Naam</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                                   value="{{$user->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                                   value="{{$user->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Wachtwoord</label>
                                        <div class="col-sm-10">
                                            @if (Route::has('password.request'))
                                                <a class="btn  btn-primary" href="{{ route('password.request') }}">
                                                    {{ __('Change your password') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="mb-3 mt-2">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Taal</label>
                                        <div class="col-sm-10">
                                            <x-lang-dropdown name="language" value="{{$user->language}}"/>
                                            <small class="text-muted">Taal van de website en emails die u
                                                ontvangt indien beschikbaar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary">Wijzigingen opslaan</button>
                                </div>
                            </div>
                        </form>
                    </div>
{{--                    @if(Auth::user()->roles[0]->level <= 1)--}}
{{--                        <div class="tab-pane fade" id="v-consulent" role="tabpanel">--}}
{{--                            <form id="form" action="{{route('consulent.add')}}" method="post">--}}
{{--                                @csrf--}}
{{--                                <div class="card">--}}
{{--                                    <div class="card-header d-flex justify-content-between">--}}
{{--                                        Consulent toevoegen--}}
{{--                                    </div>--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>--}}
{{--                                            <div class="col-sm-10">--}}
{{--                                                <input class="form-control" type="email" name="consulent" required>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="card-footer">--}}
{{--                                        <button class="btn btn-primary">Voeg toe</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>
        </div>
    </div>
@endsection
