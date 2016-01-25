<?php

namespace App\Http\Controllers\Backend;

use App\Models\Game;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\GameRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('backend.games.list')
            ->with('games', $games)
            ->with('homeList', Game::getHomeList())
            ->with('statusList', Game::getStatusList());
    }

    public function create()
    {
        return view('backend.games.create')
            ->with('homeList', Game::getHomeList())
            ->with('statusList', Game::getStatusList());
    }

    public function store(GameRequest $request)
    {
        Game::create($request->all());

        Flash::success(trans('general.created_msg'));

        return redirect(route('admin.games'));
    }

    public function edit(Game $game)
    {
        return view('backend.games.edit')
            ->with('game', $game)
            ->with('homeList', Game::getHomeList())
            ->with('statusList', Game::getStatusList());
    }

    public function update(Game $game, GameRequest $request)
    {
        $game->update($request->all());

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.games'));
    }

    public function destroy(Game $game)
    {
        $game->delete();

        Flash::success(trans('general.delete_msg'));

        return redirect(route('admin.games'));
    }
}
