@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Planeten</h1>
        <a href="{{ route('planets.create') }}" class="btn btn-primary">Neuen Planeten erstellen</a>
        <ul class="list-group mt-3">
            @foreach($planets as $planet)
                <li class="list-group-item">{{ $planet->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
