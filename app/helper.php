<?php

use App\Models\Game;

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