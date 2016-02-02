<?php

namespace App\Repositories;

use App\Models\Training;

class TrainingRepository
{
    public static function getActiveList($team_id)
    {
        return Training::where('team_id', $team_id)->where('status', Training::STATUS_ACITVE)->get();
    }
}