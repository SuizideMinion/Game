<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;

class PlanetController extends Controller
{
    public function index()
    {
        return view('planets.index', ['planets' => Planet::all()]);
    }

    public function create()
    {
        return view('planets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'player_id' => 'required|exists:players,id'
        ]);

        Planet::create($request->all());
        return redirect()->route('planets.index');
    }

    // Weitere Methoden für show, edit, update, destroy...
}
