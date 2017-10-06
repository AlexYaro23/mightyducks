<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\TelegramUpdate;
use App\Models\TelegramUser;
use App\Repositories\GameRepository;
use App\Repositories\StatRepository;
use App\Utils\TelegramService;


class TelegramController extends Controller
{
    protected $telegram;
    protected $gameRepository;

    public function __construct(TelegramService $telegram, GameRepository $gameRepository)
    {
        $this->telegram = $telegram;
        $this->gameRepository = $gameRepository;
    }

    public function index()
    {
        $update = TelegramUpdate::find(68);

        $data = json_decode($update);
        $data = json_decode($update->update);
        $msgId = $data->callback_query->message->message_id;
        $answerRow = $data->callback_query->data;
        $answerPars = explode('/', $answerRow);
        $tgUserId = $answerPars[2];
        $playerId = $answerPars[3];
        $player = Player::find($playerId);
        $player->telegram_id = $tgUserId;
        $player->save();

        $msg = "Player " . $player->name . " mapped with his telegram account";

        $this->telegram->closeMapMsg($msgId, $msg);


//        $tgUser = TelegramUser::where('tg_id', 249401878)->first();
//        $msg = sprintf("Alex, new user has been added\n%s %s %s\nMap it with existing player:\n", $tgUser->first_name, $tgUser->last_name, $tgUser->username);
//
//        $players = Player::all();
//
//        $buttons = [];
//        foreach ($players as $player) {
//            $buttons[] = [['callback_data' => '/map/' . $tgUser->tg_id . '/' . $player->id, 'text' => $player->name]];
//        }
//
//        $this->telegram->sendMapTgUserMsg($msg, $buttons);


    }
}
