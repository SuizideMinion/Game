<div class="element-container">

    @foreach ($elements as $element)
        <div class="element-card">
            <div class="front-facing"
                 @if (isset($element['bgImage']))
                     style="background-image: url('{{ $element['bgImage'] }}');border: 0;"
                @endif>
                <h1 class="abr">{{ $element['symbol'] }}</h1>
                <p class="title">{{ $element['name'] }}</p>
                <span class="atomic-number">{{ $element['atomic_number'] }}</span>
                <span class="atomic-mass">{{ $element['atomic_mass'] }}</span>
            </div>
            <div class="back-facing">
                <p>{{ $element['description'] }}</p>
                <p><a class="btn" href="{{ $element['link'] }}" target="_blank">More info</a></p>
            </div>
        </div>
    @endforeach

</div>
