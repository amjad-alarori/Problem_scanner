@php
    $id = 'a' . rand(0, 2_000_000);
@endphp

<div class="language-form">
    <p>Vertalingen</p>
    <div class="{{$id}}-language-form-row-container">
        @if(isset($values))
            @php
                $parsedValues = explode(';', $values);
                array_pop($parsedValues);
            @endphp
            @foreach($parsedValues as $parsedValue)
                @php
                    $idd = 'a' . rand(0, 2_000_000);
                @endphp
                <div class="language-form-row row mb-2">
                    <div class="col-3">
                        <select id="{{$idd}}" class="form-control" name="language[{{$name}}][lang][]">
                            @foreach(\App\Helpers\LanguageHelper::$allLanguageIsos as $country => $iso)
                                <option value="{{$iso}}" @if($iso == explode('=', $parsedValue)[0]) selected @endif >{{$country}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" name="language[{{$name}}][value][]" value="{{explode('=', $parsedValue)[1]}}" class="form-control"
                               placeholder="{{$placeholder ?? ucfirst($name)}}">
                    </div>
                    <div class="col-1 text-center"><a class="btn btn-danger"
                                                      onclick="$(this).parent().parent().remove()"><i
                                class="fa fa-trash"></i></a></div>
                </div>
                <script>
                    $('#{{$idd}}').select2();
                </script>
            @endforeach
        @endif
    </div>
    <div class="mt-2">
        <a id="{{$id}}-dupe-language-form" class="btn btn-primary btn-sm">+</a>
    </div>
</div>
<script>
    $(document).on('click', '#{{$id}}-dupe-language-form', function () {
        appendLangRow()
    })

    function appendLangRow() {
        let id = Math.floor(Math.random() * 1_000_000_000) + 1_000_000;
        $('.{{$id}}-language-form-row-container').append(`<div class="language-form-row row mb-2">
        <div class="col-3">
            <select id="${id}" class="form-control" name="language[{{$name}}][lang][]">
                @foreach(\App\Helpers\LanguageHelper::$allLanguageIsos as $country => $iso)
        <option value="{{$iso}}" @if($iso == "nl") selected @endif >{{$country}}</option>
                @endforeach
        </select>
    </div><div class="col">
    <input type="text" name="language[{{$name}}][value][]" class="form-control"
                   placeholder="{{$placeholder ?? ucfirst($name)}}">
</div><div class="col-1 text-center"><a class="btn btn-danger" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></a></div></div>`);
        $('#' + id).select2();
    }

    @if(!isset($values))
    appendLangRow()
    @endif
</script>
