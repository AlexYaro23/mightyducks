<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GameRepository;
use App\Utils\TelegramService;
use Telegram\Bot\Api;
use Log;

class TelegramController extends Controller
{
    protected $telegram;
    protected $gameRepository;

    public function __construct(TelegramService $telegram, GameRepository $gameRepository)
    {
        $this->telegram = $telegram;
        $this->gameRepository = $gameRepository;
    }

    public function index(Request $request)
    {
        Log::error('Telegram update has come');
        $this->telegram->getWebhookUpdates();
        Log::error('Telegram update has been processed');
    }

    public function check()
    {
        $telegram = new Api();
        $response = $telegram->getWebhookUpdates();
    }

    public function setWebhook()
    {
        $telegram = new Api();

        $response = $telegram->setWebhook(['url' => 'https://mightyducks.od.ua/telegram']);

        return $response;

    }

    public function removeWebhook()
    {
        $telegram = new Api();
        $response = $telegram->removeWebhook();

        return $response;

    }
}
