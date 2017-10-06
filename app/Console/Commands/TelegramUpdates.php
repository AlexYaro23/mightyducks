<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\TelegramUpdate;
use App\Models\TelegramUser;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use App\Utils\TelegramService;
use Illuminate\Console\Command;

class TelegramUpdates extends CommandParent
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_tg_updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receives telegram updates';


    protected $telegram;
    protected $gameRepository;
    protected $playerRepository;

    /**
     * Create a new command instance.
     *
     * @param TelegramService $telegram
     * @param GameRepository $gameRepository
     * @param PlayerRepository $playerRepository
     */
    public function __construct(TelegramService $telegram, GameRepository $gameRepository, PlayerRepository $playerRepository)
    {
        parent::__construct();

        $this->telegram = $telegram;
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->startLog();

        $response = $this->telegram->getUpdates();
        $this->info("Received updates: " . count($response));
        foreach ($response as $update) {
            $telegramUpdate = TelegramUpdate::where('update_id', $update['update_id'])->first();

            if ($telegramUpdate != null) {
                continue;
            }

            $telegramUpdate = TelegramUpdate::create([
                'update_id' => $update['update_id'],
                'update' => $update,
            ]);
            $this->info("Processing new update: " . $telegramUpdate->id);

            $data = json_decode($telegramUpdate->update);
            if ($this->isCallback($data)) {
                $this->info("It's a callback");
                $this->processCallback($data);
            } elseif ($this->isNewChatMemberMsg($data)) {
                $tgUser = $this->addNewChatMember(
                    $data->message->new_chat_member->id,
                    $data->message->new_chat_member->first_name,
                    $data->message->new_chat_member->last_name,
                    $data->message->new_chat_member->username
                );

                if ($tgUser->wasRecentlyCreated) {
                    $this->informAdminAboutNewUser($tgUser);
                }
            } else {
                $this->info("It's a message");
            }
        }

        $this->endLog();
    }

    private function processCallback($data)
    {
        if ($this->checkIfVote($data->callback_query->data)) {
            $this->processVote($data);
        } elseif ($this->checkIfMapUser($data->callback_query->data)) {
            $this->processMapUser($data);
        }
    }

    private function addNewChatMember($id, $first_name, $last_name, $username)
    {
        $tgUser = TelegramUser::updateOrCreate(
            ['tg_id' => $id],
            [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username
            ]);

        return $tgUser;
    }

    private function informAdminAboutNewUser($tgUser)
    {
        $this->info("ADMIN!!!New user was added: " . $tgUser->username);

        $msgMock = config('mls.inform_admin_about_new_user');
        $msg = sprintf($msgMock, $tgUser->first_name, $tgUser->last_name, $tgUser->username);
        $buttons = $this->getPlayersMapButtons($tgUser->tg_id);
        $this->telegram->sendMapTgUserMsg($msg, $buttons);

        $this->info('Sent map message to admin');
    }

    private function processVote($data)
    {
        $userId = $data->callback_query->from->id;
        $voteId = $data->callback_query->message->message_id;
        $vote = $data->callback_query->data;

        $player = Player::where('telegram_id', $userId)->first();
        if ($player == null) {
            return;
        }

        $game = Game::where('telegram_msg_id', $voteId)->first();

        if ($game == null) {
            return;
        }

        $info['game_id'] = $game->id;
        $info['player_id'] = $player->id;
        if ($vote == '/yes') {
            StatRepository::createOrUpdateGameVisit($info, Stat::GAME_VISITED);
        } elseif ($vote == '/no') {
            StatRepository::createOrUpdateGameVisit($info, Stat::GAME_NOT_VISITED);
        } else {
            $this->info("Unknown msg");
            return;
        }

        $msg = $game->getVoteMsg('telegram');
        $msg .= $this->gameRepository->getVisitsForVote($game->id);

        try {
            $this->telegram->updateVote($voteId, $msg);
            $this->info("Message was updated successfully");
        } catch (\Exception $ex) {
            $this->info("Exception occured. " . $ex->getMessage());
        }
    }

    private function processMapUser($data)
    {
        $this->info("Mapping new user");
        $msgId = $data->callback_query->message->message_id;
        $answerRow = $data->callback_query->data;
        $answerPars = explode('/', $answerRow);
        $tgUserId = $answerPars[2];
        $playerId = $answerPars[3];
        $player = $this->playerRepository->addTgUserIdToPlayer($playerId, $tgUserId);
        $this->info($player->name . " successfully mapped with telegram account");
        $msgMock = config('mls.mapped_user_success_msg');
        $msg = sprintf($msgMock, $player->name);

        $this->info("Closing admin map message");
        $this->telegram->closeMapMsg($msgId, $msg);
    }

    private function getPlayersMapButtons($tgId)
    {
        $players = Player::all();
        $buttons = [];
        foreach ($players as $player) {
            $buttons[] = [['callback_data' => '/map/' . $tgId . '/' . $player->id, 'text' => $player->name]];
        }

        return $buttons;
    }

    private function isCallback($data)
    {
        return isset($data->callback_query);
    }

    private function isNewChatMemberMsg($data)
    {
        return isset($data->message->new_chat_member);
    }

    private function checkIfVote($data)
    {
        return in_array($data, ['/yes', '/no']);
    }

    private function checkIfMapUser($data)
    {
        return strpos($data, '/map/') !== false;
    }
}
