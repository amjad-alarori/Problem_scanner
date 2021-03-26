<textarea name="{{$name ?? ""}}" cols="30" rows="20" class="form-control summernote"
          @if(isset($required)) required @endif>{!! $value ?? '' !!}</textarea>
