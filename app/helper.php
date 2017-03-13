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

function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

function str2url($str) {
    $str = rus2translit($str);
    $str = strtolower($str);
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    $str = trim($str, "-");

    return $str;
}