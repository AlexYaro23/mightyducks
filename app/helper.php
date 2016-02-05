<?php

use App\Models\Game;
use Illuminate\Support\Facades\Log;

function fixMlsUrl($url) {
    $domain = config('mls.domain');
    if (strpos($url, $domain) === false) {
        if ($url[0] != '/') {
            return $domain . '/' . $url;
        }
        return $domain . $url;
    }

    return $url;
}


function parseInt($str) {
    return preg_replace("/[^0-9]/", "", trim($str));
}

function clearPlayerName($str) {
    return trim(str_replace('&nbsp;', '', $str));
}

function getCircleClass(Game $game) {
    if ($game->score1 == $game->score2) {
        return 'draw';
    } elseif ($game->score1 < $game->score2 && $game->isHome()) {
        return 'loose';
    } elseif ($game->score1 > $game->score2 && !$game->isHome()) {
        return 'loose';
    }

    return 'win';
}

function countWins($gameList) {
    $wins = 0;

    foreach ($gameList as $game) {
        if ($game->score1 === null || $game->score2 === null) {
            continue;
        }

        if (
            ($game->score1 > $game->score2 && $game->isHome()) ||
            ($game->score1 < $game->score2 && !$game->isHome())
        ) {
            $wins++;
        }
    }

    return $wins;
}

function countDraws($gameList) {
    $draws = 0;

    foreach ($gameList as $game) {
        if ($game->score1 === null || $game->score2 === null) {
            continue;
        }
        if ($game->score1 == $game->score2) {
            $draws++;
        }
    }

    return $draws;
}

function countLooses($gameList) {
    $looses = 0;

    foreach ($gameList as $game) {
        if ($game->score1 === null || $game->score2 === null) {
            continue;
        }
        if (
            ($game->score1 > $game->score2 && !$game->isHome()) ||
            ($game->score1 < $game->score2 && $game->isHome())
        ) {
            $looses++;
        }
    }

    return $looses;
}

function getGoalsRow($gameList) {
    $scored = $missed = 0;
    foreach ($gameList as $game) {
        if ($game->score1 === null || $game->score2 === null) {
            continue;
        }

        if ($game->isHome()) {
            $scored += $game->score1;
            $missed += $game->score2;
        } else {
            $scored += $game->score2;
            $missed += $game->score1;
        }

    }

    $diff = $scored - $missed;
    return $scored . ' - ' . $missed . ' ( ' . (string) $diff . ' )';
}

function countPlayedGames($gameList) {
    $games = 0;

    foreach ($gameList as $game) {
        if ($game->score1 !== null && $game->score2 !== null) {
            $games++;
        }
    }

    return $games;
}

function sendVkMsg($msg)
{
    $url = 'https://api.vk.com/method/messages.send';
    $params = array(
        'chat_id' => env('VK_CHAT_ID'),
        'message' => $msg,
        'access_token' => env('VK_TOKEN'),
        'v' => '5.38',
    );

    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));

    return $result;
}