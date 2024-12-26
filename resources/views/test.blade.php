@extends('blank')

@section('styles')
@endsection

@section('contend')

    {{--    <x-card :footer="'Test hier unten was '">--}}
    {{--        <x-slot:header>--}}
    {{--            Test | Irgendwas | Keine AHnung--}}
    {{--        </x-slot:header>--}}
    {{--        <x-element-card :elements="$elements">--}}

    {{--        </x-element-card>--}}
    {{--    </x-card>--}}

    <x-gui>
        <x-slot:title>Hi</x-slot:title>
        {{--                <x-gui-r-l-split>--}}
        {{--                    <x-slot:left>--}}
        {{--                        <x-gui-button target="test" name="Punkte" active="1" class="w-100 m-1"></x-gui-button>--}}
        {{--                        <x-gui-button target="test" name="Kollektoren" active="0" class="w-100 m-1"></x-gui-button>--}}
        {{--                        <x-gui-button target="test" name="Erhabenenscore" active="0" class="w-100 m-1"></x-gui-button>--}}
        {{--                    </x-slot:left>--}}
        {{--                    <x-slot:right>--}}
        {{--                    </x-slot:right>--}}
        {{--                </x-gui-r-l-split>--}}
        <x-gui-menu-bar>
            <x-gui-main>
                @foreach(\App\Models\DeUserData::orderBy('score', 'DESC')->whereNot('score', 0)->limit(100)->get() as $user)
                    <li>
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="d-flex gap-3 left align-items-center">
                                <span class="sl">{{ $loop->iteration }}</span>
                                <div class="avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="name">{{ $user->spielername }}</div>
                            </div>
                            <p class="dgt right">{{ shortenNumber($user->score, 0) }}</p>
                        </div>
                        <div class="avatar-shape">
                            <img src="images/avatar-shape.png" alt="avatar shape">
                        </div>
                    </li>

                @endforeach
            </x-gui-main>
        </x-gui-menu-bar>
    </x-gui>

@endsection
