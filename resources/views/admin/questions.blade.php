@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h3>Questions</h3>
            <a href="{{route('questions.create')}}" class="btn btn-orange">Create</a>
        </div>
        <hr>
        <div class="list-group">
            @foreach($questions as $question)
                <div class="list-group-item d-flex justify-content-between">
                    <div>
                        {{$question->question}}
                        <br>
                        <a href="{{route('questions.edit', [$question])}}">Bewerk <i class="fa fa-edit"></i></a>
                    </div>
                    <img src="{{$question->image}}" style="height:40px;"/>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('input[type=file]').addClass('custom-file-input')
    </script>
@endpush

