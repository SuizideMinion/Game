@extends('blank')

@section('contend')
    <x-gui :nav="[route('ranking.index', 'player') => 'Punkte', route('ranking.index', 'collectors') => 'Kollektoren']">
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
                    <div class="dgt right d-flex gap-3">
                        <p data-bs-toggle="tooltip" title="Punkte">{{ shortenNumber($user->score, 2) }}</p>
                        <p data-bs-toggle="tooltip" title="Kollektoren">{{ shortenNumber($user->col, 2) }}</p>
                        <p data-bs-toggle="tooltip" title="Erhabenenpunkte"> {{ shortenNumber($user->ehscore, 2) }}</p>
                        <p data-bs-toggle="tooltip" title="Rundenpunkte">{{ shortenNumber($user->roundpoints, 2) }}</p>
                    </div>
                </div>
                <div class="avatar-shape">
                    <div class="backgroundImage">
                </div>
            </li>
        @endforeach
    </x-gui>
@endsection
