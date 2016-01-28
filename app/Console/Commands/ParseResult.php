<?php

namespace App\Console\Commands;

use App\Repositories\GameRepository;
use Illuminate\Console\Command;
use Yangqi\Htmldom\Htmldom;

class ParseResult extends Command
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
            $result = $this->parseResult($game);
        }

        $this->info(PHP_EOL . 'Script end');
    }

    private function parseResult($game)
    {
        $html = new Htmldom($this->getGameUrl($game->mls_url));

        if ($html == null) {
            $this->error('Invalid URL for game_id ' . $game->id);
            exit;
        }

        $score1Row = $html->find('table.match-day td.score span.score b.score-h', 0);
        $score2Row = $html->find('table.match-day td.score span.score b.score-a', 0);

        if ($score1Row != null && $score2Row != null) {
            $validator = Validator::make(
                ['score1' => $score1Row->innertext, 'scrote2' => $score2Row->innertext],
                [
                    'score1' => 'required|integer',
                    'score2' => 'required|integer',
                ]
            );
            if (!$validator->fails()) {
                $game->score1 = $score1Row->innertext;
                $game->score2 = $score2Row->innertext;
            }
        }

        $resultTable = $html->find('table.season-list', 0);

    }

    private function getGameUrl($url)
    {
        return config('mls.domain') . '/raspisanie/' . $url;
    }
}
