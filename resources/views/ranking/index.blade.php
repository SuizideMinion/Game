@extends('blank')

@section('contend')
    <x-gui :nav="[route('ranking.index', 'player') => 'punkte', route('ranking.index', 'collectors') => 'kollektoren']">
        {{--        <x-slot:header>--}}
        {{--            <li>--}}
        {{--                <x-gui-button active="0" class="active" :target="route('ranking.index', 'dasvhj')" name="Test"></x-gui-button>--}}
        {{--            </li>--}}
        {{--        </x-slot:header>--}}
        <x-slot:title>Ranking</x-slot:title>
        @foreach($users as $user)
            <li>
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div class="d-flex gap-3 left align-items-center">
                        <span class="sl">{{ $loop->iteration }}</span>
                        <div class="avatar">
                            {{ getGreekSymbol($user->rang) }}
                        </div>
                        <div class="name">{{ $user->spielername }}</div>
                    </div>
                    <p class="dgt right">{{ shortenNumber($user->score, 2) }}</p>
                </div>
                <div class="avatar-shape">
                    <img src="{{asset('images/avatar-shape.png')}}" alt="avatar shape">
                </div>
            </li>
        @endforeach
    </x-gui>
@endsection
