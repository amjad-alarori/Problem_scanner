<select class="langClass form-control" name="{{$name ?? ''}}">
    @if(isset($all))
        <option value="all" selected>All languages</option>
    @endif
    @foreach(\App\Helpers\LanguageHelper::$allLanguageIsos as $name => $iso)
        <option value="{{$iso}}"
        @if(isset($value))
            @if($value == $iso) selected @endif
        @else
            @if($iso == "nl" && !isset($all)) selected @endif
        @endif
        >{{$name}}</option>
    @endforeach
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        @php($iso = "__")
        <option value="{{$iso}}"
                @if(isset($value))
                @if($value == $iso) selected @endif
            @endif
        >See all keys on blades</option>
        @endif
</select>

<script>
    $(document).ready(function () {
        $(".langClass").select2({
            theme: 'bootstrap4'
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

