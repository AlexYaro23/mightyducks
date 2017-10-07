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

    const ADMIN_COMMAND = [
        'quick_visits' => 'quickvisit'
    ];

    const DEFAULT_VOTE_CLOSED_MSG = 'Vote Closed';
    protected $telegram;
    protected $gameRepository;
    protected $playerRepository;
    protected $statsRepository;
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
        $this->statsRepository = new StatRepository();
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

    public function closeAdminVote($msgId, $msgText = self::DEFAULT_VOTE_CLOSED_MSG)
    {
        $this->telegram->editMessage([
            'chat_id' => $this->ownerId,
            'message_id' => $msgId,
            'text' => $msgText
        ]);
    }

    public function getUpdates()
    {
        return $this->telegram->getUpdates();
    }

    public function sendAdminMsqWithButtons($msg, $buttons)
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

    public function editAdminMsqWithButtons($msg, $buttons, $msgId)
    {
        $reply_markup = $this->telegram->replyKeyboardMarkup([
            'inline_keyboard' => $buttons
        ]);

        $response = $this->telegram->editMessage([
            'chat_id' => $this->ownerId,
            'message_id' => $msgId,
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
            Log::info("It's a new chat member");
            $tgUser = $this->addNewChatMember(
                $response->message->new_chat_member->id,
                $response->message->new_chat_member->first_name,
                $response->message->new_chat_member->last_name,
                $response->message->new_chat_member->username
            );

            if ($tgUser->wasRecentlyCreated) {
                Log::info("Informing admin about new user");
                $this->informAdminAboutNewUser($tgUser);
            }
        } elseif ($this->checkIfAdminCommand($response)) {
            Log::info("It's an admin command");
            $this->processAdminCommand($response);
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
        } elseif ($this->checkIfQuickVisitsCallback($message->callback_query->data)) {
            Log::info("quickvisit user");
            $this->processQuickVisitsCallback($message);
        } elseif ($this->checkIfCloseVoteCallback($message->callback_query->data)) {
            Log::info("close admin vote");
            $this->closeVoteForMessage($message);
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
        $this->sendAdminMsqWithButtons($msg, $buttons);

        Log::info('Sent map message to admin');
    }

    private function getPlayersMapButtons($tgId)
    {
        $players = Player::all();
        $buttons = [];
        foreach ($players as $player) {
            $buttons[] = [['callback_data' => '/map/' . $tgId . '/' . $player->id, 'text' => $player->name]];
        }

        $buttons[] = $this->getClosVoteButton();

        return $buttons;
    }

    private function checkIfAdminCommand($response)
    {
        return $response->message->chat->id == $this->ownerId;
    }

    private function processAdminCommand($response)
    {
        if ($this->checkIfQuickVisitsCommand($response)) {
            Log:info("Quick visits command");
            $this->sendQuickVisitsVote();
        }
    }

    private function checkIfQuickVisitsCommand($response)
    {
        return isset($response->message) && $response->message->text == self::ADMIN_COMMAND['quick_visits'];
    }

    private function sendQuickVisitsVote()
    {
        $game = $this->gameRepository->getNextGame();

        if ($game == null) {
            Log::info('No next game');
            return;
        }
        Log::info('Processing game id: ' . $game->id);

        $buttons = $this->getQuickVisitButtons($game);
        $msg = $this->getQuickVisitsMsg($game);

        $this->sendAdminMsqWithButtons($msg, $buttons);
    }

    private function getClosVoteButton()
    {
        return [['callback_data' => '/closevotecommand', 'text' => 'Close Vote']];
    }

    private function checkIfQuickVisitsCallback($data)
    {
        return strpos($data, '/quickvisitadd/') !== false;
    }

    private function checkIfCloseVoteCallback($data)
    {
        return strpos($data, '/closevotecommand') !== false;
    }

    private function processQuickVisitsCallback($data)
    {
        Log::info("Processing quick visits");
        $msgId = $data->callback_query->message->message_id;
        $answerRow = $data->callback_query->data;
        $answerPars = explode('/', $answerRow);
        $gameId = $answerPars[2];
        $playerId = $answerPars[3];
        $game = Game::find($gameId);
        $this->statsRepository->triggerUserVisit($gameId, $playerId);
        Log::info("Visit triggered for game: " . $gameId . " player: " . $playerId);

        $buttons = $this->getQuickVisitButtons($game);
        $msg = $this->getQuickVisitsMsg($game);

        $this->editAdminMsqWithButtons($msg, $buttons, $msgId);
    }

    private function getQuickVisitButtons($game)
    {
        $players = $this->playerRepository->getActivePlayersForTournament($game->tournament_id);

        $buttons = [];
        foreach ($players as $player) {
            $buttons[] = [['callback_data' => '/quickvisitadd/' . $game->id . '/' . $player->id, 'text' => $player->name]];
        }

        return $buttons;
    }

    private function getQuickVisitsMsg($game)
    {
        $msgMock = config('mls.quickvisitadd_msg');
        $msg = sprintf($msgMock, $game->team);
        $msg .= $this->gameRepository->getVisitsForVote($game->id);

        return $msg;
    }

    private function closeVoteForMessage($message)
    {
        $msgId = $message->callback_query->message->message_id;
        $this->closeAdminVote($msgId);
    }
}