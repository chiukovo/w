<?php

if (!function_exists('testHelper')) {

    /**
     * 測試helper function 是否能啟用
     *
     * @return string
     */
    function testHelper()
    {
        return 'ok';
    }
}

if (!function_exists('getClientIp')) {
    function getClientIp() {
        foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP','HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return '127.0.0.1';
    }
}


if (!function_exists('maskName')) {
    function maskName($name) {
        return mb_substr($name, 0, 2) . str_repeat('*', max(0, mb_strlen($name) - 2));
    }
}