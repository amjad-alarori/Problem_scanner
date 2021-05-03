@extends('layouts.admin')@section('content')
    <div class="container mt-5">
        {{ Form::open(array('route' => array('categories.store'),'method'=>'post','files'=>true)) }}
        <div class="form-group">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
            Categorie naam:
            {{ Form::text('name',null,array('class'=>'form-control mb-3')) }}
            Hoort bij scan:
            {{ Form::select('scan',$scans,null,array('class'=>'form-control mb-3')) }}

                Color in de grafieken (pak de kleur van het thema):
                <input type="color" name="color" required><br><br>

            Foto:
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">       {{Form::file('image')}}

                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
        </div>

        {{Form::submit(__('buttons.primary'),array('class'=>'btn btn-primary'))}}
        {{Form::close()}}
        <div class="mt-5">
            <h3>Categories:</h3>
        </div>
        <div class="list-group">
            @foreach($categories as $category)
                <a class="list-group-item list-group-item-action" data-toggle="collapse"
                   href="#{{'collapse'.$category->id}}" role="button" aria-expanded="false"
                   aria-controls="{{'collapse'.$category->id}}">{{$category->name}}<img src="{{$category->image}}"
                                                                                        class="float-right"
                                                                                        style="height:40px;"></a>
                <div class="collapse p-5" id="{{'collapse'.$category->id}}">

                    {{ Form::open(array('route' => array('categories.update',['category'=>$category->id]),'method'=>'put','files'=>true)) }}
                    <div class="form-group">
                        Category:
                        {{ Form::text('category',$category->name,array('class'=>'form-control mb-3')) }}
                        Hoort bij scan:
                        {{ Form::select('scan',$scans,$category->scan_id,array('class'=>'form-control mb-3')) }}
                        Color in de grafieken (pak de kleur van het thema):
                        <input type="color" name="color" value="{{$category->color}}" required><br><br>
                        <div class="input-group mt-3 mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">       {{Form::file('image')}}

                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> {{Form::submit(__('buttons.warning'),array('class'=>'btn btn-warning'))}}
                            {{Form::close()}}</div>
                        <div class="col-md-6">
                            <form action="{{route('categories.destroy',['category'=>$category->id])}}"
                                  method="post">@csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger float-right">{{__('buttons.danger')}}</button>
                            </form>
                        </div>

                    </div>
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
