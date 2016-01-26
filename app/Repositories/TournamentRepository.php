<?php

namespace App\Repositories;

use App\Models\Tournament;

class TournamentRepository
{
    public function getActiveScheduled()
    {
        return Tournament::whereNotNull('link')->where('status', Tournament::STATUS_ACTIVE)->get();
    }
}