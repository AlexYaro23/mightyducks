<?php

namespace App\Repositories;

use App\Models\League;

class LeagueRepository
{
    private $model;

    public function __construct(League $model)
    {
        $this->model = $model;
    }

    public function getAllActive()
    {
        return $this->model->where('status', League::STATUS_ACTIVE)->get();
    }
}