<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Stat;
use App\Repositories\GameRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Yangqi\Htmldom\Htmldom;

class ParseResult extends CommandParent
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parseresult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing games results';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Script start');

        $games = (new GameRepository())->getOpenned();

        $this->info('Games to parse: ' . $games->count());

        foreach ($games as $game) {
            $this->info('Starting game: ' . $game->id);

            $html = new Htmldom($this->getGameUrl($game->mls_url));

            if ($html == null) {
                $this->error('Invalid URL for game_id ' . $game->id);
                continue;
            }

            if (!$this->parseResult($game, $html)) {
                $this->info('No game result');
                continue;
            }

            $this->info('Game result saved');

            $stats = $this->parseStats($game, $html);

            /*if (count($stats) < 1) {
                $this->info('No stats parsed');
                continue;
            }*/

            $this->info('Parse stats: ' . count($stats));

            (new GameRepository())->saveGameStats($game, $stats);
        }

        $this->info(PHP_EOL . 'Script end');
    }

    private function parseResult(Game $game, Htmldom $html)
    {
        $score1Row = $html->find('table.match-day td.score span.score b.score-h', 0);
        $score2Row = $html->find('table.match-day td.score span.score b.score-a', 0);

        if ($score1Row != null && $score2Row != null) {
            $data = [
                'score1' => parseInt($score1Row->innertext),
                'score2' => parseInt($score2Row->innertext)
            ];

            $validator = Validator::make(
                $data,
                [
                    'score1' => 'required|integer',
                    'score2' => 'required|integer',
                ]
            );

            if (!$validator->fails()) {
                (new GameRepository())->saveScore($game, $data);

                return true;
            }
        }

        return false;
    }

    private function getGameUrl($url)
    {
        if (strpos($url, '/chempionat/') !== false) {
            return config('mls.domain') . $url;
        }

        return config('mls.domain') . '/raspisanie/' . $url;
    }

    private function parseStats(Game $game,Htmldom $html)
    {
        $table = $html->find('table.season-list', 0);

        if (!$table) {
            $this->error('No stats table for game ' . $game->id);

            return null;
        }

        $stats = [];

        $team_class = $game->isHome() ? 'home_event' : 'away_event';
        foreach ($table->find('tr') as $row) {
            $statRow = $row->find('td.' . $team_class, 0);

            if ($statRow) {
                array_push($stats, $this->parseAndDetermineStat($statRow));
            }
        }

        return $stats;
    }

    private function parseAndDetermineStat($statRow)
    {
        $stat = [
            'player' => clearPlayerName($statRow->plaintext),
            'parameter' => $this->parseParameter($statRow)
        ];

        return $stat;
    }

    private function parseParameter($statRow)
    {
        $img = $statRow->find('img', 0);
        if ($img) {
            $href = $img->src;
            $title = $img->title;
            if ($href && $title) {
                if (strtolower($title) == 'Гол' || strpos($href, 'ball.png') !== false) {
                    return Stat::GOAL;
                }

                if (strtolower($title) == 'Голевые пасы' || strpos($href, 'boot.png') !== false) {
                    return Stat::ASSIST;
                }

                if (strtolower($title) == 'Жёлтая' || strpos($href, 'yellow_card.png') !== false) {
                    return Stat::YELLOW_CARD;
                }

                if (strtolower($title) == 'Красная' || strpos($href, 'red_card.png') !== false) {
                    return Stat::RED_CARD;
                }
            }
        }
    }
}
