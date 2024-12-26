@if (isset($title))
    <!-- Page Alert Start -->
    <header class="main-header">
        <div class="page-alert position-relative">
            <p class="text-center">
                {{ $title }}
            </p>
            <div class="dismiss-btn">
                <button onclick="dismissIframe()">X</button>
            </div>
        </div>
    </header>
@endif

@if (isset($nav))
    <section class="shop-content">
        <!-- Shop menubar -->
        <div class="shop-menubar">
            <ul class="d-flex gap-2">
                @foreach($nav as $key => $value)
                <li><a href="{{ $key }}" class="">{{ $value }}</a></li>
{{--                <li><a href="{{ route('ranking.index', 'collectors') }}" class="">Kollektoren</a></li>--}}
                @endforeach
            </ul>
        </div>
    </section>
@endif

<!-- Main Start -->
<main class="scrollable-content" id="scrollable">
    <section class="content-wrapper ranking">
        <div class="main-content w-100">
            <div class="inner h-100">
                <div class="overflow-y-auto">
                    <ul>
                        {{ $slot }}
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Main End -->

@if (isset($footer))
    <footer>
        {{ $footer }}
    </footer>
@endif
