@extends('blank')

@section('styles')
    <style>


    </style>
@endsection

@section('contend')

    <x-card :footer="'Test hier unten was '">
        <x-slot:header>
            Test | Irgendwas | Keine AHnung
        </x-slot:header>
        <x-element-card :elements="$elements">

        </x-element-card>
    </x-card>

@endsection
