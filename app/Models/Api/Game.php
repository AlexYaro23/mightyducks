<?php

namespace App\Models\Api;

use App\Models\Game as GameModel;
use App\Models\Team;

class Game
{
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

    public function __construct(GameModel $model)
    {
        $this->teamA = Team::find(config('mls.team_id'))->name;
        $this->logoA = url(Team::LOGO);
        $this->teamB = $model->team;
        $this->logoB = url($model->getTeamPhotoLink());
        $this->date = $model->date->format('H:i d-m-Y');
        $this->place = $model->place;
        $this->round = $model->round;
        $this->championship = $model->tournament->name;

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
                array_push($this->{$property}, $players[$stat->player_id] . $count);
            }
        }
    }
}
