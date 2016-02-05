<?php

namespace App\Console\Commands;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Reminder extends Command
{
    const PERIOD = 3;
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
    protected $description = 'Reminds about nearest games into VK team chart';


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

        $date = Carbon::now();

        $gameList = Game::where('date', '>=', $date->format('Y-m-d 00:00:00'))
            ->where('date', '<=', $date->addDays(self::PERIOD)->format('Y-m-d 23:59:59'))
            ->where('reminder', Game::MSG_NOT_SENT)->get();


        if ($gameList->count() < 1) {
            $this->error('No games to remind');
            exit;
        }

        foreach ($gameList as $game) {

            $msg = config('mls.chat_game_msg');
            $msg = str_replace('%game%', $game->date->format('H:i d-m-Y') . ' ' . $game->team,  $msg);
            $msg = str_replace('%url%', route('game.visit', ['id' => $game->id]), $msg);

            $result = sendVkMsg($msg);

            if (preg_match('/"response":[0-9]+/', $result)) {
                $game->reminder = Game::MSG_SENT;
                $game->save();

                $this->comment($result);
                $this->comment('Sent msg for game: ' . $game->id);
            }
        }

        $this->info('Script end');
    }
}
