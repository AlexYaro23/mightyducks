<?php

namespace App\Repositories;

use App\Http\Requests\Backend\GameRequest;
use App\Models\Console\GameMlsBO;
use App\Models\Console\GameMlsEntity;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GameRepository
{
    public function addParsedGame(GameMlsEntity $gameEntity)
    {
        $gameBO = new GameMlsBO($gameEntity);
        $data = $gameBO->toArray();

        $validator = Validator::make($data, GameRequest::getRules());
        if (!$validator->fails()) {
            $game = Game::where('mls_url', $data['mls_url'])->first();
            if (!$game) {
                $game = Game::create($data);

                Storage::put(
                    config('img.team_logo') . $game->team . '.png',
                    file_get_contents($data['icon'])
                );

                return $game;
            }
        }

        return false;
    }

    public function getOpenned()
    {
        return Game::where('status', Game::getNonePlayedStatus())->get();
    }
}