<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Team;
use App\Models\League;
use App\Models\Team as TeamModel;
use App\Repositories\GameRepository;
use App\Http\Controllers\Controller;

class LeaguesController extends Controller
{
    public function all()
    {
        return League::all();
    }
}