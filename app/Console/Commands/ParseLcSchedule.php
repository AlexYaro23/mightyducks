<?php

namespace App\Console\Commands;

use App\Events\GameDateChange;
use App\Http\Requests\Backend\GameRequest;
use App\Models\Game;
use App\Models\Tournament;
use App\Repositories\GameRepository;
use App\Repositories\TournamentRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Utils\VkHelper;
use Illuminate\Support\Facades\Validator;


class ParseLcSchedule extends CommandParent
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lc_schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing lc schedule';


    const LC_ID = 6;
    /**
     * @var TournamentRepository
     */
    private $tournamentRepository;
    /**
     * @var GameRepository
     */
    private $gameRepository;


    public function __construct(TournamentRepository $tournamentRepository, GameRepository $gameRepository)
    {
        parent::__construct();

        $this->tournamentRepository = $tournamentRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->startLog();

        $htmlResponse = VkHelper::getLcSchedule();
        $tournament = $this->tournamentRepository->getLastTournamentForLeague(self::LC_ID);

        $this->parseGames($htmlResponse, $tournament);

        $this->endLog();
    }

    private function parseGames($htmlResponse, $tournament)
    {
        $games = explode(PHP_EOL, $htmlResponse);
        $roundDate = null;
        foreach ($games as $game) {
            preg_match('/([0-9][0-9]\.[0-9][0-9]\.[0-9]{4})/', $game, $dateData);

            if (isset($dateData[1])) {
                $roundDate = $dateData[1];
            }

            if (strpos($game, 'MightyDucks') !== false) {
                preg_match('/^([0-9:]+)\s*\"([^\"]+)\"\s*-?\s*\"([^\"]+)\"/', $game, $gameData);

                if (count($gameData) > 1) {
                    try {
                        $team = strpos($gameData[2], 'MightyDucks') !== false ? $gameData[3] : $gameData[2];
                        $data = [
                            'team_id' => 1,
                            'team' => $team,
                            'date' => Carbon::parse($gameData[1] . $roundDate)->format('Y-m-d H:i:s'),
                            'home' => Game::HOME,
                            'status' => Game::getNonePlayedStatus(),
                            'place' => 'Санаторий СБУ "Одесса"',
                            'tournament_id' => $tournament->id
                        ];

                        $this->timedInfo('Found game with ' . $data['team'] . ' on ' . $data['date']);
                        $this->gameRepository->processParsedGame($data);
                    } catch (\Exception $ex) {
                        //ToDo add error event
                    }

                }
            }
        }
    }
}
