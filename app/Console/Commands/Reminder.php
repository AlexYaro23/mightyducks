<?php

namespace App\Console\Commands;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Reminder extends Command
{
    const PERIOD = 2;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remindes about nearest games into VK team chart';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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

        $date = Carbon::now()->addDays(self::PERIOD);

        $gameList = Game::where('date', '>=', $date->format('Y-m-d 00:00:00'))
            ->where('date', '<=', $date->format('Y-m-d 23:59:59'))->get();

        if ($gameList->count() < 1) {
            $this->error('No games to remind');
            exit;
        }

        foreach ($gameList as $game) {
            dd(route('game.visit', ['id' => $game->id]));
        }

        $this->info('Script end');
    }
}
