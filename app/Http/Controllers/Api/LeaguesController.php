<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\League;
use App\Models\Tournament;
use App\Http\Controllers\Controller;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    private $repository;

    public function __construct(LeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $leagues = $this->repository->getAllActive();
        $leaguesApi = [];
        foreach ($leagues as $league) {
            $leaguesApi[] = new League($league);
        }

        return $leaguesApi;
    }

    public function tournaments(Request $request)
    {
        $leagueIds = $request->get('leagues');

        if (empty($leagueIds)) {
            return [];
        }

        return Tournament::whereIn('league_id', $leagueIds)->get();
    }
}