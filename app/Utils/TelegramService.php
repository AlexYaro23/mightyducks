<?php

namespace App\Utils;

use Telegram\Bot\Api;
use Telegram\Bot\TelegramClient;

class TelegramService
{
    protected $telegram;
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
}