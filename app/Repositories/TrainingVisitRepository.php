<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\Training;
use App\Models\TrainingVisit;

class TrainingVisitRepository
{

    public static function getTrainingVisits($training_id)
    {
        return TrainingVisit::where('training_id', $training_id)
            ->where('visit', TrainingVisit::VISITED)->get();
    }

    public static function saveQuickVisits($request)
    {
        if (!Training::find($request->get('training_id'))) {
            return;
        }

        self::setNotVisited($request->get('training_id'));
        foreach ($request->all() as $key => $input) {
            if (strpos($key, 'player_') !== false) {
                $id = str_replace('player_', '', $key);
                if (Player::find($id)) {

                    self::addVisit($request->get('training_id'), $id);
                }
            }
        }
    }

    private static function addVisit($training_id, $player_id)
    {
        $stat = TrainingVisit::where('training_id', $training_id)
            ->where('player_id', $player_id)
            ->first();

        if ($stat) {
            $stat->visit = TrainingVisit::VISITED;

            $stat->save();
        } else {
            TrainingVisit::create([
                'training_id' => $training_id,
                'player_id' => $player_id,
                'visit' => TrainingVisit::VISITED
            ]);
        }
    }

    public static function setNotVisited($training_id)
    {
        TrainingVisit::where('training_id', $training_id)
            ->update(['visit' => TrainingVisit::NOT_VISITED]);
    }

    public static function createOrUpdateVisit(array $data, $visit)
    {
        $stat = TrainingVisit::where('training_id', $data['training_id'])
            ->where('player_id', $data['player_id'])
            ->first();

        $visit = TrainingVisit::convetValue($visit);
        if (!$stat) {
            TrainingVisit::create([
                'training_id' => $data['training_id'],
                'player_id' => $data['player_id'],
                'visit' => $visit
            ]);
        } else {
            $stat->visit = $visit;

            $stat->save();
        }
    }
}