@extends('layouts.admin')@section('content')
    <div class="container mb-5 mt-5">
        <h1>Resultaten overzicht</h1>
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <ul class="list-group">
            @foreach($results as $result)
                <li class="list-group-item">
                    <a href="{{route('results.show',$result)}}">
                        {{$result->name}}

                    </a>
                    <div class="float-right w-50">
                        <form action="{{route('results.destroy',$result)}}" class=" float-right" method="post">
                            @method('DELETE')
                            @csrf
                            <div class="row">
                                <div class="col-9">                          <div class="pt-2">{{$result->created_at}}</div>
                                </div>
                                <div class="col-3">                            <button type="submit" class="btn btn-danger float-right"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </form>
                        </div>
                </li>
            @endforeach
        </ul>

    </div>
    <div style="margin:0 auto; display: block; width:50px; padding:0;">
        {{ $results->links("pagination::bootstrap-4") }}
    </div>
@endsection

