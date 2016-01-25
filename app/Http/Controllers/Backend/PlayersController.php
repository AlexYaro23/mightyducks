<?php

namespace App\Http\Controllers\Backend;

use App\Models\Player;
use App\Models\Team;
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

    public function edit(Player $player)
    {
        $users = User::lists('name', 'id');
        $teams = Team::lists('name', 'id');

        return view('backend.players.edit')
            ->with('player', $player)
            ->with('users', $users)
            ->with('teams', $teams);
    }

    public function update(Player $player, PlayerRequest $request)
    {
        $player->update($request->all());

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.players'));
    }
}
