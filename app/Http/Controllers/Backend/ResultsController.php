<?php

namespace App\Http\Controllers\Backend;

use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Repositories\StatRepository;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\StatRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class ResultsController extends Controller
{
    protected $statRepository;
    protected $team;

    public function __construct(StatRepository $statRepository)
    {
        $this->statRepository = $statRepository;
        $this->team = Team::find(config('mls.team_id'));
    }

    public function index()
    {
        return view('backend.results.index');
    }
}
