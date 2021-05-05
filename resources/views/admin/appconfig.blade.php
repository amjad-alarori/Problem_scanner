@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <form action="{{route('appconfig.store')}}" method="post" enctype="multipart/form-data">
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
                        @foreach($appconfigs as $key => $valueArray)
                            <div class="form-group row">
                                <div class="col-3">
                                    {{$key}}
                                </div>
                                <div class="col-9">
                                    @if($valueArray['Type'] == "select")
                                        <select name="config[{{$key}}]" id="">
                                            @foreach($valueArray['Value'] as $keyy => $item)
                                                <option
                                                    value="{{$keyy}}"
                                                    @if($keyy == \App\Helpers\AppConfigHelper::GetConfig($key)) selected @endif
                                                >{{$item}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        @if($valueArray['Type'] === 'file')
                                            <div class="d-flex justify-content-between">
                                                <div class="input-group mr-2">
                                                    <div class="custom-file">
                                                        <input type="file" name="{{$key}}" class="custom-file-input"
                                                               id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <a href="" target="_blank" class="btn btn-primary"><i
                                                        class="fa fa-download"></i></a>
                                            </div>
                                            @php
                                                $value = \App\Helpers\AppConfigHelper::GetConfig($key);
                                            @endphp
                                            <small
                                                class="@if($value == "") text-danger @else text-muted @endif">{{$value == "" ? "No file uploaded" : $value}}</small>
                                        @else
                                            <input type="{{$valueArray['Type']}}" name="config[{{$key}}]"
                                                   class="form-control"
                                                   value="{{\App\Helpers\AppConfigHelper::GetConfig($key)}}">
                                        @endif
                                    @endif
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
