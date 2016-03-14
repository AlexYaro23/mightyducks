<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use App\Models\Training;
use App\Repositories\GameRepository;
use App\Repositories\TrainingVisitRepository;
use App\Repositories\StatRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TrainingVisitsController extends Controller
{
    public function index()
    {
        $trainingList = Training::all();

        return view('backend.training_visits.list')->with('trainingList', $trainingList);
    }

    public function edit(Training $training)
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = Player::where('team_id', $team->id)->get();

        $visitList = TrainingVisitRepository::getActiveTrainingVisits($training->id);

        $visitList = $visitList->lists('visit', 'player_id');

        return view('backend.training_visits.edit')
            ->with('playerList', $playerList)
            ->with('visitList', $visitList)
            ->with('training', $training);
    }

    public function store(Request $request)
    {
        TrainingVisitRepository::saveQuickVisits($request);

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.trainingvisits'));
    }
}