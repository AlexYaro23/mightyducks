<?php

namespace App\Models\Api;

use App\Models\Team as TeamModel;
use App\Utils\TeamStats;

class Team
{
    public $name;
    public $logo;
    public $playedGames;
    public $wins;
    public $draws;
    public $looses;
    public $goalsData;

    public function __construct(TeamModel $team)
    {
        $this->name = $team->name;
        $this->logo = url($team->getLogoLink());
    }

    public function addStats($gameList)
    {
        $teamStats = new TeamStats($gameList);

        $this->playedGames = $teamStats->countPlayedGames();
        $this->wins = $teamStats->countWins();
        $this->draws = $teamStats->countDraws();
        $this->looses = $teamStats->countLooses();
        $this->goalsData = $teamStats->getGoalsRow();
    }
}