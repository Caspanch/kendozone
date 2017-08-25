<?php

namespace App\Http\Controllers;

use App\Championship;
use App\Fight;
use App\Grade;
use App\FightersGroup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Xoco70\LaravelTournaments\Exceptions\TreeGenerationException;
use Xoco70\LaravelTournaments\Models\ChampionshipSettings;
use Xoco70\LaravelTournaments\TreeGen\TreeGen;

class TreeController extends Controller
{
    /**
     * Display a listing of trees.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $grades = Grade::getAllPlucked();
        $tournament = FightersGroup::getTournament($request);
        return view('trees.index', compact('tournament', 'grades'));
    }

    /**
     * Build Tree
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {

        $tournament = FightersGroup::getTournament($request); // Builder

        if (Auth::user()->cannot('store', [FightersGroup::class, $tournament])) {
            throw new AuthorizationException();
        }
        foreach ($tournament->championships as $championship) {
            $generation = $championship->chooseGenerationStrategy();

            try {
                $generation->run();
                flash()->success(trans('msg.championships_tree_generation_success'));
            } catch (TreeGenerationException $e) {
                flash()->error($e->message);
            } finally {
            }

        }

        return redirect(route('tree.index', $tournament->slug))->with('activeTreeTab', $request->activeTreeTab);
    }

    public function single(Request $request)
    {
        $championship = Championship::find($request->championship);
        $grades = Grade::getAllPlucked();
        return view('pdf.tree', compact('championship', 'grades'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $championshipId)
    {
        $numFight = 0;
        $groups = FightersGroup::with('fights')
            ->where('championship_id', $championshipId)
//            ->where('round','>',1)
            ->get();
        $fights = $request->directElimination_fighters;
        foreach ($groups as $group) {
            foreach ($group->fights as $fight) {
                // Find the fight in array, and update order
                $fight->c1 = $fights[$numFight++];
                $fight->c2 = $fights[$numFight++];
                $fight->save();
            }
        }
        return back();
    }

}
