@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{--                <div class="card-header">{{ __('Register') }}</div>--}}
                    <div class="card-header">Registreren</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row justify-content-center">
                                {{--                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                        </div>
                                    <input id="name" type="text" placeholder="Naam"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                {{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                        </div>
                                    <input id="email" type="email" placeholder="Email adres"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                {{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                                        </div>

                                    <input id="password" type="password" placeholder="Wachtwoord"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                {{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}
                                {{--                            <h3><i class="fas fa-key"></i></h3>--}}
                                {{--                            <div class="col-md-6">--}}

                                {{--                                <input id="password-confirm" type="password" placeholder="Bevestig wachtwoord" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
                                {{--                            </div>--}}
                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Bevestig wachtwoord"
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row mb-0 justify-content-center">
                                <div class="row">
                                    <input class="form-check-input" type="checkbox" name="showPassword"
                                           id="showPassword">
                                    <label class="form-check-label" for="showPassword">
                                        Maak wachtwoord zichtbaar
                                    </label>
                                </div>
                                <br>
                                <br>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn" id="registerBtn">
                                        {{ __('Registreren') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
