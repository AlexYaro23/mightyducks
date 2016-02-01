<?php

namespace App\Repositories;

use App\Models\Stat;
use Illuminate\Support\Facades\Log;

class StatRepository
{
    public static function createOrUpdateGameVisit(array $data, $visit)
    {
        $stat = Stat::firstOrCreate($data);
        $stat->parameter = Stat::getParameterVisit();
        $stat->value = Stat::getValueVisit($visit);

        $stat->save();
    }
}