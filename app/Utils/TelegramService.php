<?php

namespace App\Utils;

use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\TelegramUpdate;
use App\Models\TelegramUser;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use Telegram\Bot\Api;
use Telegram\Bot\TelegramClient;
use Log;

class TelegramService
{
    protected $telegram;
    protected $gameRepository;
    protected $playerRepository;
    protected $client;
    protected $chatId;
    protected $ownerId;
    protected $buttons = [
        [['callback_data' => '/yes', 'text' => 'играю']],
        [['callback_data' => '/no', 'text' => 'пропускаю']],
    ];

    public function __construct()
    {
        $this->telegram = new Api();
        $this->client = new TelegramClient();
        $this->chatId = env('TELEGRAM_CHAT_ID');
        $this->ownerId = env('TELEGRAM_OWNER_CHAT_ID');
        $this->gameRepository = new GameRepository();
        $this->playerRepository = new PlayerRepository();
    }

    public function startVote($msg)
    {
        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'inline_keyboard' => $this->buttons
        ]);

        $response = $this->telegram->sendMessage([
            'chat_id' => $this->chatId,
            'text' => $msg,
            'reply_markup' => $reply_markup,
            'parse_mode' => 'html'
        ]);

        return $response->getMessageId();
    }

    public function updateVote($msgId, $msgText)
    {
        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'inline_keyboard' => $this->buttons
        ]);

        $this->telegram->editMessage([
            'chat_id' => $this->chatId,
            'message_id' => $msgId,
            'text' => $msgText,
            'reply_markup' => $reply_markup,
            'parse_mode' => 'html'
        ]);
    }

    public function closeVote($msgId, $msgText)
    {
        $this->telegram->editMessage([
            'chat_id' => $this->chatId,
            'message_id' => $msgId,
            'text' => $msgText,
            'parse_mode' => 'html'
        ]);
    }

    public function getUpdates()
    {
        return $this->telegram->getUpdates();
    }

    public function sendMapTgUserMsg($msg, $buttons)
    {
        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'inline_keyboard' => $buttons
        ]);

        $response = $this->telegram->sendMessage([
            'chat_id' => $this->ownerId,
            'text' => $msg,
            'reply_markup' => $reply_markup,
            'parse_mode' => 'html'
        ]);

        return $response->getMessageId();
    }

    public function closeMapMsg($msgId, $msgText)
    {
        $this->telegram->editMessage([
            'chat_id' => $this->ownerId,
            'message_id' => $msgId,
            'text' => $msgText,
            'parse_mode' => 'html'
        ]);
    }

    public function getWebhookUpdates()
    {
        $response = $this->telegram->getWebhookUpdates();
        Log::info(json_encode($response));
        $response = json_decode($response);
        $updateId = $response->update_id;

        $telegramUpdate = TelegramUpdate::where('update_id', $updateId)->first();

        if ($telegramUpdate != null) {
            return;
        }

        $telegramUpdate = TelegramUpdate::create([
            'update_id' => $updateId,
            'update' => json_encode($response),
        ]);

        Log::info("Processing new update: " . $telegramUpdate->id);


        if ($this->isCallback($response)) {
            Log::info("It's a callback");
            $this->processCallback($response);
        } elseif ($this->isNewChatMemberMsg($response)) {
            $tgUser = $this->addNewChatMember(
                $response->message->new_chat_member->id,
                $response->message->new_chat_member->first_name,
                $response->message->new_chat_member->last_name,
                $response->message->new_chat_member->username
            );

            if ($tgUser->wasRecentlyCreated) {
                $this->informAdminAboutNewUser($tgUser);
            }
        } else {
            Log::info("It's a message");
        }
    }

    private function isCallback($message)
    {
        return isset($message->callback_query);
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

    private function processCallback($message)
    {
        if ($this->checkIfVote($message->callback_query->data)) {
            Log::info("new vote");
            $this->processVote($message);
        } elseif ($this->checkIfMapUser($message->callback_query->data)) {
            Log::info("new map user");
            $this->processMapUser($message);
        }
    }

    private function processVote($data)
    {
        $userId = $data->callback_query->from->id;
        $voteId = $data->callback_query->message->message_id;
        $vote = $data->callback_query->data;

        Log::info("Vote value: " . $vote);

        $player = Player::where('telegram_id', $userId)->first();
        if ($player == null) {
            Log::error("Player not found. Tg user id: " . $userId);
            return;
        }

        $game = Game::where('telegram_msg_id', $voteId)->first();

        if ($game == null) {
            Log::error("Game not found. Tg msg id: " . $voteId);
            return;
        }

        $info['game_id'] = $game->id;
        $info['player_id'] = $player->id;
        if ($vote == '/yes') {
            StatRepository::createOrUpdateGameVisit($info, Stat::GAME_VISITED);
        } elseif ($vote == '/no') {
            StatRepository::createOrUpdateGameVisit($info, Stat::GAME_NOT_VISITED);
        } else {
            Log::info("Unknown msg");
            return;
        }

        $msg = $game->getVoteMsg('telegram');
        $msg .= $this->gameRepository->getVisitsForVote($game->id);

        try {
            $this->updateVote($voteId, $msg);
            Log::info("Message was updated successfully");
        } catch (\Exception $ex) {
            Log::error("Exception occured. " . $ex->getMessage());
        }
    }

    private function processMapUser($data)
    {
        Log::info("Mapping new user");
        $msgId = $data->callback_query->message->message_id;
        $answerRow = $data->callback_query->data;
        $answerPars = explode('/', $answerRow);
        $tgUserId = $answerPars[2];
        $playerId = $answerPars[3];
        $player = $this->playerRepository->addTgUserIdToPlayer($playerId, $tgUserId);
        Log::info($player->name . " successfully mapped with telegram account");
        $msgMock = config('mls.mapped_user_success_msg');
        $msg = sprintf($msgMock, $player->name);

        Log::info("Closing admin map message");
        $this->closeMapMsg($msgId, $msg);
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
        Log::info("ADMIN!!!New user was added: " . $tgUser->username);

        $msgMock = config('mls.inform_admin_about_new_user');
        $msg = sprintf($msgMock, $tgUser->first_name, $tgUser->last_name, $tgUser->username);
        $buttons = $this->getPlayersMapButtons($tgUser->tg_id);
        $this->sendMapTgUserMsg($msg, $buttons);

        Log::info('Sent map message to admin');
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
}