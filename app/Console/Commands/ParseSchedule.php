<?php

namespace App\Console\Commands;

use App\Models\Console\GameMlsEntity;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Repositories\TournamentRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Yangqi\Htmldom\Htmldom;

class ParseSchedule extends CommandParent
{
    const TEAM_ID = 1;
    const LEAGUE_ID = 1;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parseschedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing team schedule for mls';

    protected $tournament;

    public function __construct()
    {
        parent::__construct();

        $this->tournament = new TournamentRepository();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->startLog();
        $team = Team::find(self::TEAM_ID);

        if ($team == null) {
            $this->error('Team with id: ' . self::TEAM_ID . ' not found');
            exit;
        }

        $tournamentList = $this->tournament->getActiveScheduled(self::LEAGUE_ID);

        if ($tournamentList->count() < 1) {
            $this->error('No tournaments');
            exit;
        }

        $this->info('Tournaments count: ' . $tournamentList->count());

        foreach ($tournamentList as $key => $tournament) {
            $this->info('Tournament ' . ++$key . ': ' . $tournament->name);

            $html = new Htmldom($tournament->link);
            $table = $html->find('table.match-day', 0);

            if ($table == null) {
                $this->error('No matchday info');
                continue;
            }

            $gameList = $this->parseGameLinks($table, $team);

            $gameList = collect($gameList);

            $this->info('Games found: ' . $gameList->count());

            foreach($gameList->reverse() as $game) {
                $game->setTournamentId($tournament->id);
                $game->setTeamId($team->id);
                $game->setSearchTeamName($team->name);
                (new GameRepository())->addParsedGame($game);
            }
        }

        $this->endLog();
    }

    private function parseGameLinks($table, $team)
    {
        $gameList = [];

        $roundValue = null;
        foreach ($table->find('tr') as $row) {
            $round = $row->find('h3.solid', 0);
            if ($round) {
                $roundValue = $round->innertext;
                continue;
            }

            if (!$this->checkIfNeededTeamRow($row, $team)) {
                continue;
            }

            $gameEntity = $this->fillGameMlsEntityForTeam($row, $roundValue);

            if ($gameEntity->isValid()) {
                array_push($gameList, $gameEntity);
            }
        }

        return $gameList;
    }

    private function fillGameMlsEntityForTeam($row, $round)
    {
        $gameEntity = new GameMlsEntity();
        $gameEntity->setRound($round);

        $teamHome = $row->find('td.team-h a', 0);
        if ($teamHome) {
            $gameEntity->setTeamHome($teamHome->innertext);
        }

        $teamHomeIcon = $row->find('td.team-ico-h div.team-embl img', 0);
        if ($teamHomeIcon) {
            $gameEntity->setTeamHomeIcon($teamHomeIcon->src);
        }

        $teamVisit = $row->find('td.team-a a', 0);
        if ($teamVisit) {
            $gameEntity->setTeamVisit($teamVisit->innertext);
        }

        $teamVisitIcon = $row->find('td.team-ico-a div.team-embl img', 0);
        if ($teamVisitIcon) {
            $gameEntity->setTeamVisitIcon($teamVisitIcon->src);
        }

        $gameDate = $row->find('td.match-day-date', 0);
        if ($gameDate) {
            $gameEntity->setMatchDate(Carbon::parse(trim($gameDate->innertext)));
        }

        $gameLinkNotPlayed = $row->find('span.score a.so_not_played', 0);
        $gameLinkPlayed = $row->find('span.score a.bdtooltip', 0);
        if ($gameLinkNotPlayed) {
            $gameEntity->setLink($gameLinkNotPlayed->href);
        } elseif ($gameLinkPlayed) {
            $gameEntity->setLink($gameLinkPlayed->href);
        }

        $placeTd = $row->find('td', -2);

        if ($placeTd) {
            $place = $placeTd->find('a', 0);
            if ($place) {
                $gameEntity->setPlace($place->innertext);
            }
        }

        return $gameEntity;
    }

    private function checkIfNeededTeamRow($row, $team)
    {
        $home = $row->find('td.team-h a', 0);
        $visitor = $row->find('td.team-a a', 0);

        if (
            $home != null && $visitor != null &&
            ($home->innertext == $team->name || $visitor->innertext == $team->name)
        ) {
            return true;
        }

        return false;
    }
}
