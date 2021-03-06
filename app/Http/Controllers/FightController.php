<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Tournament;
use Illuminate\Http\Request;

class FightController extends Controller
{
    /**
     * Display a listing of the fights.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grades = Grade::getAllPlucked();
        $tournament = Tournament::with(['championships.firstRoundFights' => function ($query) {
            $query->with(['competitor1.user', 'competitor2.user', 'team1', 'team2']);
        }])->where('slug', $request->tournament)
            ->first();
        return view('fights.index', compact('tournament', 'grades'));

    }
}
