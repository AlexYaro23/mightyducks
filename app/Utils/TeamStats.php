<?php

namespace App\Utils;

class TeamStats
{
    protected $games;

    public function __construct($gameList)
    {
        $this->games = $gameList;
    }

    public function countWins()
    {
        $wins = 0;

        foreach ($this->games as $game) {
            if ($game->score1 === null || $game->score2 === null) {
                continue;
            }

            if (
                ($game->score1 > $game->score2 && $game->isHome()) ||
                ($game->score1 < $game->score2 && !$game->isHome())
            ) {
                $wins++;
            }
        }

        return $wins;
    }

    public function countDraws()
    {
        $draws = 0;

        foreach ($this->games as $game) {
            if ($game->score1 === null || $game->score2 === null) {
                continue;
            }
            if ($game->score1 == $game->score2) {
                $draws++;
            }
        }

        return $draws;
    }

    public function countLooses()
    {
        $looses = 0;

        foreach ($this->games as $game) {
            if ($game->score1 === null || $game->score2 === null) {
                continue;
            }
            if (
                ($game->score1 > $game->score2 && !$game->isHome()) ||
                ($game->score1 < $game->score2 && $game->isHome())
            ) {
                $looses++;
            }
        }

        return $looses;
    }

    public function getGoalsRow()
    {
        $scored = $missed = 0;
        foreach ($this->games as $game) {
            if ($game->score1 === null || $game->score2 === null) {
                continue;
            }

            if ($game->isHome()) {
                $scored += $game->score1;
                $missed += $game->score2;
            } else {
                $scored += $game->score2;
                $missed += $game->score1;
            }

        }

        $diff = $scored - $missed;

        return $scored . ' / ' . $missed . ' ( ' . (string)$diff . ' )';
    }

    public function countPlayedGames()
    {
        $cnt = 0;
        foreach ($this->games as $game) {
            if ($game->score1 !== null && $game->score2 !== null) {
                $cnt++;
            }
        }

        return $cnt;
    }
}