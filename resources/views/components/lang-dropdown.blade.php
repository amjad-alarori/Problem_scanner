<select class="langClass" name="{{$name ?? ''}}">
    @foreach(\App\Helpers\LanguageHelper::$allLanguageIsos as $name => $iso)
        <option value="{{$iso}}"
        @if(isset($value))
            @if($value == $iso) selected @endif
        @else
            @if($iso == "nl") selected @endif
        @endif
        >{{$name}}</option>
    @endforeach
</select>

<script>
    $(document).ready(function () {
        $(".langClass").select2({
            // templateResult: function (idioma) {
            //     if (idioma.id !== undefined) {
            //         return $("<span><img src='/assets/images/flags/" + idioma.id.replace(/ /g, "_") + ".png'/> " + idioma.text + "</span>");
            //     }
            // },
            // templateSelection: function (idioma) {
            //     if (idioma.id !== undefined) {
            //         return $("<span><img src='/assets/images/flags/" + idioma.id.replace(/ /g, "_") + ".png'/> " + idioma.text + "</span>");
            //     }
            // }
        });
    });
</script>

