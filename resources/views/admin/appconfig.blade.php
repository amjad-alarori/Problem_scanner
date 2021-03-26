@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <form action="{{route('appconfig.store')}}" method="post">
            @csrf
            <div class="d-flex justify-content-between">
                <h1>System configuration</h1>
                <div class="p-2 pr-2">
                    <button class="btn btn-sm btn-info d-block"><i
                            class="fa fa-save"></i></button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if(count($appconfigs))
                        @foreach($appconfigs as $key => $value)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{$key}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="config[{{$key}}]" class="form-control"
                                           value="{{\App\Helpers\AppConfigHelper::GetConfig($key)}}">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="mb-0">No system configurations found</p>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
