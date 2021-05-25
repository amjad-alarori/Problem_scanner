@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row scan-title">
            <div class="col-9">
                <h1>{{$scan->name}}</h1>
            </div>
            <div class="col-3"><input type="text" class="form-control search_filter" data-target=".scan-question-wrapper"
                                      placeholder="Zoek kaart"></div>
        </div>
        @if($categories->count() == 0)
            <p>Er zijn nog geen categorieën aangemaakt.</p>
            @if(Auth::user()->isAdmin()) <p>Maak <a class="text-primary" href="/admin/categories">hier</a> een categorie
                aan</p>@endif

        @else
{{--            <form action="{{route('scan.show', $scan)}}" method="post" class="form-group formswitchview">--}}
{{--                @csrf--}}
{{--                <div>--}}
{{--                    <input class="switchview" type="radio" name="radiobutton" id="radiobutton1" value="single" checked="checked">--}}
{{--                    <label for="radiobutton1">Enkelvoudige weergave</label>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <input class="switchview" type="radio" name="radiobutton" id="radiobutton2" value="triple">--}}
{{--                    <label for="radiobutton2">Meervoudige weergave</label>--}}
{{--                </div>--}}
{{--                <button class="btn btn-primary" type="submit">bevestig</button>--}}
{{--            </form>--}}
            <form id="form" action="{{route('results.store')}}" method="post" class="form-group">
                @csrf
                <input type="hidden" name="scan_id" value="{{$scan ?? ''->id}}">
                <input type="hidden" name="scan" value="{{$scan ?? ''->name}}">
                @if(Auth::user()->roles[0]->level == 2)
                    <label class="scan-label mb-5">
                        <div class="scan-counter mb-2"><p>{{$counter}}</p></div>
                        <span class="row">
                            <span class="col-6">Selecteer een van uw bestaande cliënt(e)
                                <select id="selected_user"
                                        name="selected_user"
                                        class="form-control">
                                    <option value="0" selected></option>


                                    @foreach($users as $key=>$users)
                                        @if($key == 1)
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}
                                                    | {{$user->email}}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </span>
                        </span>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </label>
                @else

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <label class=" mb-5">
                        <input type="hidden" name="name" value="{{Auth::user()->name}}">
                    </label>
                @endif
                <div class="single-container-vw">
                    @foreach($categories as $category)
                        <h1 class=" category-single-name">{{$category->name}}</h1>
                        <div>
                            @if($category->questions->count() ==0)
                                <p>Er zijn nog geen vragen aangemaakt.</p><br>
                                @if(Auth::user()->isAdmin()) <p>Maak <a class="text-primary" href="/admin/questions">hier</a>
                                    een vraag
                                    aan</p>@endif
                            @else
                                @foreach($questions as $question)
                                    <div class="col-12">
                                        <div class="single-card">
                                            <div class="scan-question bk-color-card1">
                                                <h3 class="single-card-question">{{$question->question}}</h3>
                                                <h5 class="single-card-catname">Leefgebied: <i>{{$category->name}}</i></h5>
                                            </div>
                                            <div class="scan-question single-card-imgcont bk-color-card2">
                                                <img class="single-card-img mx-auto d-block" src="{{$question->image}}" style="height:200px;">
                                            <input type="hidden" value="{{$question->categories_id}}"
                                                   name="category{{$question->id}}">
                                            <div class="row scan-ratio align-center-radio margin-auto">
                                                <label class="pt-4">Nauwelijks</label>
                                                <label class="scan-ratio-label">1<br/>
                                                    <input type="radio" name="selectedvalue{{$question->id}}" value="1">
                                                </label>
                                                <label class="scan-ratio-label">2<br/>
                                                    <input type="radio" name="selectedvalue{{$question->id}}" value="2">
                                                </label>
                                                <label class="scan-ratio-label">3 <br/>
                                                    <input type="radio" name="selectedvalue{{$question->id}}" value="3">
                                                </label>
                                                <label class="scan-ratio-label">4 <br/>
                                                    <input type="radio" name="selectedvalue{{$question->id}}" value="4">
                                                </label>
                                                <label class="scan-ratio-label">5 <br/>
                                                    <input type="radio" name="selectedvalue{{$question->id}}" value="5">
                                                </label>
                                                <label class="pt-4">
                                                    Zeer ernstige
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="container-pagenation">
                                        {{$questions->links()}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach

                    <button type="submit"
                            class="btn btn-primary btn-margin-single">{{__('buttons.create_scan')}}</button>
                @endif
            </form>
    </div>
@endsection
@push('scripts')
    <script>
        $("#form").submit(function (e) {
            if ($('#selected_user').val() === '0' && $('#name').val() === '') {
                alert('Vul een nieuwe cliënt(e) in of selecteer een bestaande cliënt(e)');
                e.preventDefault();
            }
        });
    </script>
@endpush
