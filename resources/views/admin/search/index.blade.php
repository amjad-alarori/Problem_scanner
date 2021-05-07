@extends('layouts.admin')@section('content')
    <div class="container-sm">
        <h1 class="display-6 ml-4 font-weight-bold text-xl-center text-center mb-5">Search results</h1>
        <div class="card">
            <div class="card-header"><b>{{ $searchResults->count() }} results found for "{{ request('query') }}"</b></div>
            <div class="card-body">
                @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                    <h2>{{ ucfirst($type) }}</h2>
                    @foreach($modelSearchResults as $searchResult)
                        <ul>
                            <li><a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a></li>
                        </ul>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
