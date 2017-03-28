<?php

namespace App\Utils;

class VkHelper
{
    const VK_API_URL = 'https://api.vk.com/method/';

    public static function getLcSchedule()
    {
        $url = self::VK_API_URL . 'pages.get';
        $params = array(
            'access_token' => env('TK'),
            'owner_id' => '-119578489',
            'global' => '0',
            'site_preview' => '0',
            'title' => 'БЛИЖАЙШИЕ ИГРЫ',
            'need_source' => '0',
            'need_html' => true,
            'v' => '5.63'
        );

        $result = json_decode(file_get_contents($url, false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            )
        ))));

        sleep(1);

        try {
            $html = $result->response->html;
        } catch (\Exception $ex) {
            //ToDo alert
            exit();
        }

        return $html;
    }
}