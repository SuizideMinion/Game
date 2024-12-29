{{--<a class="suiButton {{ $active == 1 ? 'active':'' }} {{ $class ?? '' }}" href="{{ $target }}">--}}
{{--    <span>{{ $name }}</span>--}}
{{--    <div class="b-t-l"></div>--}}
{{--    <div class="b-t-l-t"></div>--}}
{{--    <div class="b-t-r"></div>--}}
{{--    <div class="b-t-r-t"></div>--}}
{{--    <div class="b-b-l"></div>--}}
{{--    <div class="b-b-l-b"></div>--}}
{{--    <div class="b-b-r"></div>--}}
{{--    <div class="b-b-r-b"></div>--}}
{{--</a>--}}
<form action="{{ $target }}" method="post">
    @if($post)
        @foreach($inputs as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        @csrf
    @endif
    <button
        type="submit"
        class="elementCardsuiButton {{ $active == 1 ? 'active':'' }} {{ $class ?? '' }}"
        onclick="{{ $target ?? ''}}"
        @foreach($datas as $key => $value )
            {{ $key }}="{{ $value }}"
        @endforeach
    >
    <div
        class="btn-inner d-flex justify-content-center gap-1 align-items-center">
        {{--                                                    <img src="images/coin.png" alt="coin">--}}
        <span>{{ $name ?? ''}}</span>
    </div>
    <div class="b-t-l"></div>
    <div class="b-t-l-t"></div>
    <div class="b-t-r"></div>
    <div class="b-t-r-t"></div>
    <div class="b-b-l"></div>
    <div class="b-b-l-b"></div>
    <div class="b-b-r"></div>
    <div class="b-b-r-b"></div>
    </button>
</form>
