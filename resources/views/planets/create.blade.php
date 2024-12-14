@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Neuen Planeten erstellen</h1>
        <form action="{{ route('planets.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Name des Planeten</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <input type="hidden" name="player_id" value="{{ 1 }}"> <!-- Annahme, dass der Spieler mit ID 1 existiert -->
            <button type="submit" class="btn btn-success mt-3">Erstellen</button>
        </form>
    </div>
@endsection
