<?php

namespace App\Console\Commands;

use App\Repositories\GameRepository;
use App\Utils\TelegramService;
use Illuminate\Console\Command;
use Telegram\Bot\Api;

class TelegramScheduler extends CommandParent
{
    const PERIOD = 3;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram_scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post votes for next games to telegram channel';

    protected $telegram;
    protected $gamesRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->telegram = new TelegramService();
        $this->gamesRepository = new GameRepository();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->startLog();
        $game = $this->gamesRepository->getFirstGameToSchedule(self::PERIOD);
        if ($game == null) {
            $this->error('No games to schedule');
            exit();
        }

        $this->info('Sending vote for game ' . $game->id);
        $msg = $game->getVoteMsg('telegram');

        $msgId = $this->telegram->startVote($msg);

        if(filter_var($msgId, FILTER_VALIDATE_INT)){
            $this->info("Updating game. Adding telegram msgId: " . $msgId);
            $this->gamesRepository->markAsVoteMsgSent($game, $msgId);
        }

        $this->info("Received response. MSG id: " . $msgId);

        $this->endLog();
    }
}
