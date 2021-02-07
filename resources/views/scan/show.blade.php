@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="scan-title">{{$scan->name}}</h1>
        @if($categories->count() == 0)
            <p>Er zijn nog geen categorieën aangemaakt.</p>
            @if(Auth::user()->isAdmin()) <p>Maak <a class="text-primary" href="/admin/categories">hier</a> een categorie
                aan</p>@endif

        @else
            <form id="form" action="{{route('results.store')}}" method="post" class="form-group">
                @csrf
                <input type="hidden" name="scan_id" value="{{$scan->id}}">
                <input type="hidden" name="scan" value="{{$scan->name}}">
                @if(Auth::user()->roles[0]->level == 2)
                <label class="scan-label mb-5">
                    <div class="scan-counter mb-2"><p>{{$counter}}</p></div>
                    <span class="row">
                        <span class="col-6">Selecteer een van uw bestaande cliënt(e)
                            <select id="selected_user"
                                    name="selected_user"
                                    class="form-control">
                                <option value="0" selected> </option>


                        @foreach($users as $key=>$users)
                                    @if($key == 1)
                                        @foreach($users as $user)
                                    <option value="{{$user->name}}">{{$user->name}} | {{$user->email}}</option>
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
                        <h1 class="pb-4 border-bottom w-100">{{$category->name}}</h1>
                        <div class="row mb-1">
                            @if($category->questions->count() ==0)
                                <p>Er zijn nog geen vragen aangemaakt.</p><br>
                                @if(Auth::user()->isAdmin()) <p>Maak <a class="text-primary" href="/admin/questions">hier</a>
                                    een vraag
                                    aan</p>@endif
                            @else
                                @foreach($category->questions as $question)
                                    <div class="col-md-6 pb-5 scan-question">
                                        <?php $counter++?>
                                        <div class="scan-counter mb-2"><p>{{$counter}}</p></div>
                                        <h3>{{$question->question}}</h3>
                                        <h5>Leefgebied: <i>{{$category->name}}</i></h5>
                                    </div>
                                    <div class="col-md-6  pb-5 pt-5 scan-question">
                                        <img src="{{$question->image}}" style="height:200px;">
                                    </div>
                                    <input type="hidden" value="{{$question->categories_id}}"
                                           name="category{{$question->id}}">
                                    <div class="row scan-ratio mb-5">
                                        <label class="pt-4">Geen probleem</label>
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
                                            Ernstig probleem
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach

                    <button type="submit"
                            class="btn btn-primary">{{__('buttons.create_scan')}}</button>
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
