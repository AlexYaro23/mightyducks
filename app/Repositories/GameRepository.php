<?php

namespace App\Repositories;

use App\Http\Requests\Backend\GameRequest;
use App\Http\Requests\Backend\StatRequest;
use App\Models\Console\GameMlsBO;
use App\Models\Console\GameMlsEntity;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
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

    public function saveScore(Game $game, array $data)
    {
        $game->score1 = $data['score1'];
        $game->score2 = $data['score2'];
        $game->status = Game::getOnlyResultStatus();

        $game->save();
    }

    public function saveGameStats(Game $game, array $stats)
    {
        $stats = $this->reformatStats($stats);

        foreach ($stats as $stat) {
            $stat['game_id'] = $game->id;
            $this->saveGameStat($stat);
        }

        $game->update(['status', Game::getPlayedStatus()]);
    }

    private function saveGameStat(array $stat)
    {
        $validator = Validator::make($stat, StatRequest::getRules());

        if (!$validator->fails()) {
            $statElem = Stat::where('game_id', $stat['game_id'])
                ->where('player_id', $stat['player_id'])
                ->where('parameter', $stat['parameter'])
                ->first();

            if ($statElem) {
                $statElem->update($stat);
            } else {
                Stat::create($stat);
            }
        }
    }

    private function reformatStats(array $stats)
    {
        $formated = [];

        foreach ($stats as $stat) {

            $player = Player::where('name', 'like', '%' . $stat['player'] . '%')->first();
            if (!$player || empty($stat['player'])) {
                continue;
            }

            if (isset($formated[$stat['parameter']][$player->id])) {
                $formated[$stat['parameter']][$player->id]['value']++;
            } else {
                $formated[$stat['parameter']][$player->id] = [
                    'value' => 1,
                    'player_id' => $player->id,
                    'parameter' => $stat['parameter']
                ];
            }
        }

        $result = [];

        foreach ($formated as $subarr) {
            foreach ($subarr as $arr) {
                array_push($result, $arr);
            }
        }

        return $result;
    }

    public static function getNextGameByTeamId($teamId)
    {
        return Game::where('team_id', $teamId)
            ->where('status', Game::getNonePlayedStatus())
            ->where('date', '>=', date('Y-m-d'))
            ->orderBy('date', 'asc')->first();
    }
}