<?php

namespace App\Http\Controllers\Backend;

use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\PlayerRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class PlayersController extends Controller
{
    public function index()
    {
        $players = Player::all();

        return view('backend.players.list')->with('players', $players);
    }

    public function create()
    {
        $users = ['' => ''] + User::lists('name', 'id')->all();
        $teams = Team::lists('name', 'id');
        $statuses = Player::$statuses;

        return view('backend.players.create')
            ->with('users', $users)
            ->with('teams', $teams)
            ->with('statuses', $statuses)
            ->with('tournaments', Tournament::all()->pluck('name', 'id'))
            ->with('selectedTournaments', []);
    }

    public function store(PlayerRequest $request)
    {
        $player = Player::create($request->all());

        $tournaments = $request->get('tournaments') ?? [];
        $player->tournaments()->sync($tournaments);

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.players'));
    }

    public function edit(Player $player)
    {
        $users = ['' => ''] + User::lists('name', 'id')->all();
        $teams = Team::lists('name', 'id');
        $statuses = Player::$statuses;

        return view('backend.players.edit')
            ->with('player', $player)
            ->with('users', $users)
            ->with('teams', $teams)
            ->with('statuses', $statuses)
            ->with('tournaments', Tournament::all()->pluck('name', 'id'))
            ->with('selectedTournaments', $player->tournaments()->pluck('id')->toArray());
    }

    public function update(Player $player, PlayerRequest $request)
    {
        $player->update($request->all());

        $tournaments = $request->get('tournaments') ?? [];
        $player->tournaments()->sync($tournaments);

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.players'));
    }

    public function destroy(Player $player)
    {
        $player->tournaments()->detach();
        $player->delete();

        Flash::success(trans('general.delete_msg'));

        return redirect(route('admin.players'));
    }
}
