@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center pt-5">

            @if(!Auth::user())
                <p class="pt-5"> Log in om de scan af te nemen.<br> nog geen login? registreer <a
                        href="/register">hier.</a></p>
            @else
                <p class="pt-5"> Klik de knop om een scan af te nemen <br><br><a class="btn btn-primary text-center" href="/scan">Neem scan af.</a></p>

            @endguest


        </div>
    </div>
@endsection
