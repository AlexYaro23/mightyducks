<?php

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