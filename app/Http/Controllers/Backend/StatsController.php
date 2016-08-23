<?php

namespace App\Http\Controllers\Backend;

use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\StatRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class StatsController extends Controller
{
    public function index()
    {
        $stats = Stat::all();
        $teamMap = Game::all()->lists('team', 'id');
        $playerMap = Player::all()->lists('name', 'id');

        return view('backend.stats.list')
            ->with('stats', $stats)
            ->with('parameterList', Stat::getParameterList())
            ->with('teamMap', $teamMap)
            ->with('playerMap', $playerMap);
    }

    public function create()
    {
        return view('backend.stats.create')
            ->with('gameList', Game::lists('team', 'id'))
            ->with('playerList', Player::lists('name', 'id'))
            ->with('parameterList', Stat::getParameterList());
    }

    public function store(StatRequest $request)
    {
        Stat::create([
            'game_id' => $request->get('game_id'),
            'player_id' => $request->get('player_id'),
            $request->get('parameter') => $request->get('value')
        ]);

        Flash::success(trans('general.created_msg'));

        return redirect(route('admin.stats'));
    }

    public function edit(Stat $stat)
    {
        return view('backend.stats.edit')
            ->with('stat', $stat)
            ->with('gameList', Game::lists('team', 'id'))
            ->with('playerList', Player::lists('name', 'id'))
            ->with('parameterList', Stat::getParameterList());
    }

    public function update(Stat $stat, StatRequest $request)
    {
        $stat->update([
            'game_id' => $request->get('game_id'),
            'player_id' => $request->get('player_id'),
            $request->get('parameter') => $request->get('value')
        ]);

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.stats'));
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();

        Flash::success(trans('general.delete_msg'));

        return redirect(route('admin.stats'));
    }
}
