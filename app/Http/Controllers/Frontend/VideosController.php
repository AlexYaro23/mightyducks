<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\GameRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class VideosController extends Controller
{
    public function index()
    {
        $team = Team::find(config('mls.team_id'));
        $games = GameRepository::getWithVideoSortedByDate($team->id);

        return view('frontend.video.list', compact('team', 'games'));
    }
}
