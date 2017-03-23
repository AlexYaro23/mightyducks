<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\Stat;
use Illuminate\Console\Command;
use \DB;

class MapPlayer2Tournamet extends CommandParent
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map_player2tournament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync players with tournaments in which they played';

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
        $this->startLog();

        $players = Player::all();

        $this->info('Players: ' . $players->count());
        foreach ($players as $player) {
            $query = DB::table('stats')
                ->join('games', 'stats.game_id', '=','games.id')
                ->select('games.tournament_id')
                ->where('stats.player_id', $player->id)
                ->where('stats.visit', Stat::GAME_VISITED)
                ->get();

            $ids = [];

            foreach($query as $row) {
                if (!in_array($row->tournament_id, $ids)) {
                    $ids[] = $row->tournament_id;
                }
            }

            $player->tournaments()->sync($ids);

            $this->info('Player ' . $player->name . ' added ' . count($ids) . ' tournaments');
        }

        $this->endLog();
    }
}
