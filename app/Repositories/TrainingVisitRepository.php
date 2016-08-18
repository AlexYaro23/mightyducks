<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\Stat;
use App\Models\Training;
use App\Models\TrainingVisit;

class TrainingVisitRepository
{

    public static function getTrainingVisits($training_id)
    {
        return TrainingVisit::where('training_id', $training_id)
            ->whereNotNull('visit')->get();
    }

    public static function getActiveTrainingVisits($training_id)
    {
        return TrainingVisit::where('training_id', $training_id)
            ->whereIn('visit', array_keys(Stat::$visitList))->get();
    }

    public static function saveQuickVisits($request)
    {
        if (!Training::find($request->get('training_id'))) {
            return;
        }

        self::removeVisits($request->get('training_id'));

        foreach ($request->all() as $key => $input) {
            if (strpos($key, 'player_') !== false && $input > 0) {
                $id = str_replace('player_', '', $key);
                if (Player::find($id)) {
                    self::addVisit($request->get('training_id'), $id, $input);
                }
            }
        }
    }

    private static function addVisit($training_id, $player_id, $visit = TrainingVisit::VISITED)
    {
        $stat = TrainingVisit::where('training_id', $training_id)
            ->where('player_id', $player_id)
            ->first();

        if ($stat) {
            $stat->visit = $visit;

            $stat->save();
        } else {
            TrainingVisit::create([
                'training_id' => $training_id,
                'player_id' => $player_id,
                'visit' => $visit
            ]);
        }
    }

    public static function setNotVisited($training_id)
    {
        TrainingVisit::where('training_id', $training_id)
            ->update(['visit' => TrainingVisit::NOT_VISITED]);
    }

    public static function removeVisits($training_id)
    {
        TrainingVisit::where('training_id', $training_id)
            ->delete();
    }

    public static function clearVisists($trainingId)
    {
        TrainingVisit::where('training_id', $trainingId)->delete();
    }

    public static function createOrUpdateVisit(array $data, $visit)
    {
        $stat = TrainingVisit::where('training_id', $data['training_id'])
            ->where('player_id', $data['player_id'])
            ->first();

        if (!$stat) {
            if ($visit) {
                TrainingVisit::create([
                    'training_id' => $data['training_id'],
                    'player_id' => $data['player_id'],
                    'visit' => $visit
                ]);
            }
        } else {
            if ($visit) {
                $stat->visit = $visit;

                $stat->save();
            } else {
                $stat->delete();
            }
        }
    }
}