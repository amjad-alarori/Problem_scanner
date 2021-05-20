@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row scan-title">
            <div class="col-9">
                <h1>{{$scan->__name}}</h1>
            </div>
            <div class="col-3"><input type="text" class="form-control search_filter"
                                      data-target=".scan-question-wrapper"
                                      placeholder="Zoek kaart"></div>
        </div>
        @if($categories->count() == 0)
            <p>Er zijn nog geen categorieën aangemaakt.</p>
            @if(Auth::user()->isAdmin()) <p>Maak <a class="text-primary" href="/admin/categories">hier</a> een categorie
                aan</p>@endif

        @else
            <form id="form" action="{{route('results.store')}}" method="post" class="form-group">
                @csrf
                <input type="hidden" name="scan_id" value="{{$scan->id}}">
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
                <div class="container">
                    @foreach($categories as $category)
                        <h1 class="pb-4 border-bottom w-100">{{$category->__name}}</h1>
                        <div class="row mb-1">
                            @if($category->questions->count() ==0)
                                <p>Er zijn nog geen vragen aangemaakt.</p><br>
                                @if(Auth::user()->isAdmin()) <p>Maak <a class="text-primary" href="/admin/questions">hier</a>
                                    een vraag
                                    aan</p>@endif
                            @else
                                @foreach($category->questions as $question)
                                    <div class="col-12">
                                        <div class="row scan-question-wrapper">
                                            <div class="col-md-6 pb-5 scan-question">
                                                <?php $counter++?>
                                                <div class="scan-counter mb-2"><p>{{$counter}}</p></div>
                                                <h3>{{$question->__question}}</h3>
                                                <h5>Leefgebied: <i>{{$category->__name}}</i></h5>
                                            </div>
                                            <div class="col-md-6  pb-5 pt-5 scan-question">
                                                <img src="{{$question->image}}" style="height:200px;">
                                            </div>
                                            <div class="row scan-ratio mb-5">
                                                <label class="pt-4">Geen probleem</label>
                                                @php
                                                    $r =random_int(0, 5);
                                                @endphp
                                                @for($i = 1; $i <=5; $i++)
                                                    <label class="scan-ratio-label">{{$i}}<br/>
                                                        <input type="radio" name="answers[{{$question->id}}]" @if($r == $i) checked="checked" @endif
                                                               value="{{$i}}">
                                                    </label>
                                                @endfor
                                                <input type="radio" class="d-none" name="answers[{{$question->id}}]"
                                                       value="0" />
{{--                                                       value="0" checked/>--}}
                                                <label class="pt-4">
                                                    Ernstig probleem
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach

                    <button type="submit"
                            class="btn btn-orange">{{__('buttons.create_scan')}}</button>
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
