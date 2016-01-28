<?php

namespace App\Models\Console;

class GameMlsBO
{
    protected $game;

    public function __construct(GameMlsEntity $game)
    {
        $this->game = $game;
    }

    public function toArray()
    {
        $data = [
            'team_id' => $this->game->getTeamId(),
            'team' => $this->getTeam(),
            'date' => $this->game->getMatchDate()->format('Y-m-d H:i:s'),
            'home' => $this->getHome(),
            'place' => $this->game->getPlace(),
            'round' => $this->game->getRound(),
            'tournament_id' => $this->game->getTournamentId(),
            'mls_id' => $this->getMlsId(),
            'mls_url' => $this->game->getLink(),
            'icon' => config('mls.domain') . $this->getIcon()
        ];

        return $data;
    }

    public function getTeam()
    {
        return $this->game->getTeamHome() == $this->game->getSearchTeamName() ?
            $this->game->getTeamVisit() : $this->game->getTeamHome();
    }

    private function getHome()
    {
        return $this->game->getTeamHome() == $this->game->getSearchTeamName() ?
            1 : 2;
    }

    private function getMlsId()
    {
        $arr = explode('/', $this->game->getLink());

        return end($arr);
    }

    private function getIcon()
    {
        return $this->game->getTeamHome() == $this->game->getSearchTeamName() ?
            $this->game->getTeamVisitIcon() : $this->game->getTeamHomeIcon();
    }
}