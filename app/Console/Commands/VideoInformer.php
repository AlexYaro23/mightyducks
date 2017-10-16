<?php

namespace App\Console\Commands;

use App\Repositories\GameRepository;
use App\Utils\TelegramService;

class VideoInformer extends CommandParent
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video_informer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends to telegram message with links on new videos with game';

    protected $fromDate = '2017-10-15 00:00:00';
    protected $gameRepository;
    protected $telegram;

    /**
     * Create a new command instance.
     *
     * @param GameRepository $gameRepository
     * @param TelegramService $telegram
     */
    public function __construct(GameRepository $gameRepository, TelegramService $telegram)
    {
        parent::__construct();

        $this->gameRepository = $gameRepository;
        $this->telegram = $telegram;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->startLog();

        $game = $this->gameRepository->getGameWithNewVideo($this->fromDate);
        if ($game == null) {
            $this->error('No games with new videos');
            exit;
        }

        $this->info('Sending new video message for game: ' . $game->id);
        $msg = $game->getVideoMsg();
        $msgId = $this->telegram->sendMsg($msg);

        if(filter_var($msgId, FILTER_VALIDATE_INT)){
            $this->info("Updating game. Adding telegram video msgId: " . $msgId);
            $this->gameRepository->markAsVideoMsgSent($game, $msgId);
        }

        $this->info("Received response. MSG id: " . $msgId);

        $this->endLog();
    }
}
