<?php

namespace App\Http\Controllers\Frontend;

use App\Events\TrainingVisitAdded;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Stat;
use App\Models\Team;
use App\Models\Training;
use App\Models\TrainingVisit;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use App\Repositories\TrainingVisitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TrainingsController extends Controller
{
    public function addVisit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'team_id' => 'required|integer|exists:teams,id',
                'training_id' => 'required|integer|exists:trainings,id',
                'visit' => 'in:' . Stat::GAME_VISITED . ',' . Stat::GAME_NOT_VISITED
            ]
        );

        if (
            !$validator->fails() &&
            isset(Auth::user()->player->id) &&
            isset(Auth::user()->player->team->id) &&
            Auth::user()->player->team->id == $request->get('team_id')
        ) {
            $data['team_id'] = $request->get('team_id');
            $data['training_id'] = $request->get('training_id');
            $data['player_id'] = Auth::user()->player->id;
            TrainingVisitRepository::createOrUpdateVisit($data, $request->get('visit'));

            $data['visit'] = $request->get('visit');
            event(new TrainingVisitAdded($data));

            return json_encode(['msg' => trans('frontend.main.visit_added'), 'status' => 'success']);
        }

        return json_encode(['msg' => trans('frontend.main.visit_add_err'), 'status' => 'error']);
    }

    public function index()
    {
        $team = Team::find(config('mls.team_id'));
        $trainingList = Training::all();
        $dayList = Training::getDayOfWeekList();

        return view('frontend.trainings.index')
            ->with('team', $team)
            ->with('trainingList', $trainingList)
            ->with('dayList', $dayList);
    }

    public function edit(Training $training)
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = PlayerRepository::getListByTeamId($team->id);
        $dayList = Training::getDayOfWeekList();
        $visitList = TrainingVisitRepository::getTrainingVisits($training->id);

        $visitList = $visitList->lists('visit', 'player_id');

        return view('frontend.trainings.edit')
            ->with('training', $training)
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('dayList', $dayList)
            ->with('visitList', $visitList)
            ->with('statusVisited', Stat::GAME_VISITED)
            ->with('statusNotVisited', Stat::GAME_NOT_VISITED);
    }
}