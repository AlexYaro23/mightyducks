<?php

namespace App\Models\Api;

use App\Models\Game as GameModel;
use App\Models\Team;

class Game
{
    public $id;
    public $teamA;
    public $teamB;
    public $logoA;
    public $logoB;
    public $date;
    public $place;
    public $round;
    public $scorers = [];
    public $assistants = [];
    public $ycs = [];
    public $rcs = [];
    public $championship;
    public $prevGameId;
    public $nextGameId;
    public $visits = [];
    public $results = [];
    public $tournamentId;
    public $description;

    public function __construct(GameModel $model, $teamName = null)
    {
        $this->id = $model->id;
        $this->teamA = $teamName ? $teamName : Team::find(config('mls.team_id'))->name;
        $this->logoA = url(Team::LOGO);
        $this->teamB = $model->team;
        $this->logoB = url($model->getTeamPhotoLink());
        $this->date = $model->date->format('H:i d-m-Y');
        $this->place = $model->place;
        $this->round = $model->round;
        $this->championship = $model->tournament->name;
        $this->tournamentId = $model->tournament_id;
        $this->description = $model->description;

        if ($model->status == GameModel::getPlayedStatus()) {
            if ($model->isHome()) {
                $this->goalsA = $model->score1;
                $this->goalsB = $model->score2;
            } else {
                $this->goalsA = $model->score2;
                $this->goalsB = $model->score1;
            }
        }
    }

    public function loadStats($stats, $players)
    {
        $data = ['goal' => 'scorers', 'assist' => 'assistants', 'yc' => 'ycs', 'rc' => 'rcs'];
        foreach ($data as $key => $property) {
            foreach ($stats[$key] as $stat) {
                $count = $stat->$key > 1 ? ' (' . $stat->$key . ')' : '';
                if (isset($players[$stat->player_id])) {
                    array_push($this->{$property}, $players[$stat->player_id] . $count);
                }

            }
        }
    }

    public function loadResults($stats, $players)
    {
        foreach ($stats as $stat => $items) {
            $this->results[$stat] = [];
            foreach ($items as $item) {
                $this->results[$stat][] = [
                    'stat_id' => $item->id,
                    'player' => $players[$item->player_id],
                    'count' => $item->$stat
                ];
            }
        }
    }

    public function loadSiblings($siblings)
    {
        if ($siblings['prev'] != null) {
            $this->prevGameId = $siblings['prev']->id;
        }

        if ($siblings['next'] != null) {
            $this->nextGameId = $siblings['next']->id;
        }
    }
}
