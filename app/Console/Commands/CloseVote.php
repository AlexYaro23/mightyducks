<?php

namespace App\Console\Commands;

use App\Repositories\GameRepository;
use App\Utils\TelegramService;

class CloseVote extends CommandParent
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close_vote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Closing open telegram votes with game visits';


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

        $game = $this->gamesRepository->getGameVoteNeedsToBeClosed();

        if ($game == null) {
            $this->info('No votes need to be closes');
            exit();
        }

        $this->info('Closing vote for game: ' . $game->id);

        $msg = $game->getVoteMsg('telegram');

        $this->telegram->closeVote($game->telegram_msg_id, $msg);
        $this->gamesRepository->markAsVoteClosed($game);

        $this->info('Vote closed');

        $this->endLog();
    }
}
