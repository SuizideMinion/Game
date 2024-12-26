<?php

namespace App\Http\Controllers;

class RankingController extends Controller
{
    public function index($id = 'player')
    {
        if ( $id == 'player' ) {
            $users = \App\Models\DeUserData::orderBy('score', 'DESC')->whereNot('score', 0)->where('npc', 0)->limit(100)->get();
            return view('ranking.index', ['users' => $users]);
        }
        else if ( $id == 'collectors') {
            $users = \App\Models\DeUserData::select('*', 'col as score')->orderBy('col', 'DESC')->whereNot('score', 0)->where('npc', 0)->limit(100)->get();
            return view('ranking.index', ['users' => $users]);
        }

    }
}
