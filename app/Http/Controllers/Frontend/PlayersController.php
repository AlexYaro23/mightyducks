<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Player;
use App\Repositories\StatRepository;
use App\Http\Controllers\Controller;

class PlayersController extends Controller
{
    public function view(Player $player)
    {
        $stats = StatRepository::getByPlayerId($player->id);

        return view('frontend.players.view')->with('player', $player)->with('stats', $stats);
    }
}