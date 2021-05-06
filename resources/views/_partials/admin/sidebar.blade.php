<div class="sidebar">
    <ul class="sidebar-nav">
        @foreach($items as $item)
            @if(count($item) == 1)
                <small class="sidebar-small">{{$item['name']}}</small>
            @else
                <li class="sidebar-nav-item">
                    @if(array_has($item, 'items'))
                        @php
                            $href = "a" . random_int(100_000, 100_000_000);
                        @endphp
                        <a class="sidebar-nav-link" data-toggle="collapse" href="#{{$href}}" role="button">
                            <div>
                                <i class="{{$item['icon']}}"></i>
                            </div>
                            <span>
                                {{$item['name']}}
                            </span>
                        </a>
                        <div class="collapse collapse-hook" id="{{$href}}">
                            @foreach($item['items'] as $subitem)
                                <a class="sidebar-nav-link" href="{{$subitem['href']}}">
                                    <div>
                                        <i class="{{$subitem['icon']}}"></i>
                                    </div>
                                    <span>
                                        {{$subitem['name']}}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <a class="sidebar-nav-link" href="{{$item['href']}}">
                            <div>
                                <i class="{{$item['icon']}}"></i>
                            </div>
                            <span>
                                {{$item['name']}}
                            </span>
                        </a>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</div>
