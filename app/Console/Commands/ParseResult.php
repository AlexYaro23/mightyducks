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
        dd($this->getGameUrl($game->mls_url));
        $html = new Htmldom($this->getGameUrl($game->mls_url));

        if ($html == null) {
            $this->error('Invalid URL for game_id ' . $game->id);
            exit;
        }

    }

    private function getGameUrl($url)
    {
        return config('mls.domain') . '/raspisanie/' . $url;
    }
}
