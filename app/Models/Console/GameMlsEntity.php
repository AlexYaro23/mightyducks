<?php

namespace App\Models\Console;

class GameMlsEntity
{
    protected $match_date;
    protected $teamHome;
    protected $teamHomeIcon;
    protected $teamVisit;
    protected $teamVisitIcon;
    protected $link;
    protected $place;
    protected $round = null;
    protected $tournamentId;
    protected $teamId;
    protected $searchTeamName;

    /**
     * @return mixed
     */
    public function getMatchDate()
    {
        return $this->match_date;
    }

    /**
     * @param mixed $match_day
     */
    public function setMatchDate($match_date)
    {
        $this->match_date = $match_date;
    }

    /**
     * @return mixed
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * @param mixed $teamHome
     */
    public function setTeamHome($teamHome)
    {
        $this->teamHome = $teamHome;
    }

    /**
     * @return mixed
     */
    public function getTeamHomeIcon()
    {
        return $this->teamHomeIcon;
    }

    /**
     * @param mixed $teamHomeIcon
     */
    public function setTeamHomeIcon($teamHomeIcon)
    {
        $this->teamHomeIcon = $teamHomeIcon;
    }

    /**
     * @return mixed
     */
    public function getTeamVisit()
    {
        return $this->teamVisit;
    }

    /**
     * @param mixed $teamVisit
     */
    public function setTeamVisit($teamVisit)
    {
        $this->teamVisit = $teamVisit;
    }

    /**
     * @return mixed
     */
    public function getTeamVisitIcon()
    {
        return $this->teamVisitIcon;
    }

    /**
     * @param mixed $teamVisitIcon
     */
    public function setTeamVisitIcon($teamVisitIcon)
    {
        $this->teamVisitIcon = $teamVisitIcon;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @param mixed $round
     */
    public function setRound($round)
    {
        $this->round = $round;
    }

    /**
     * @return mixed
     */
    public function getTournamentId()
    {
        return $this->tournamentId;
    }

    /**
     * @param mixed $tournamentId
     */
    public function setTournamentId($tournamentId)
    {
        $this->tournamentId = $tournamentId;
    }

    /**
     * @return mixed
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param mixed $teamId
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
    }

    /**
     * @return mixed
     */
    public function getSearchTeamName()
    {
        return $this->searchTeamName;
    }

    /**
     * @param mixed $searchTeamName
     */
    public function setSearchTeamName($searchTeamName)
    {
        $this->searchTeamName = $searchTeamName;
    }

    public function isValid()
    {
        if ($this->match_date && $this->teamHome && $this->teamVisit && $this->link) {
            return true;
        }

        return false;
    }
}