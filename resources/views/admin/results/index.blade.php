@extends('layouts.admin')@section('content')
    <div class="container mb-5 mt-5">
        <h1>Resultaten overzicht</h1>
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    @foreach($results as $result)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    <a href="{{route('export.show',$result)}}">
                                        {{$result->name}}
                                    </a>
                                </div>
                                <div class="col-4">
                                    <div class="pt-2">{{$result->created_at}}</div>
                                </div>
                                <div class="col-4">
                                    <form action="/admin/results/{{$result->id}}" class=" float-right" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger float-right"><i
                                                class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer">
                {{ $results->links("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
@endsection

