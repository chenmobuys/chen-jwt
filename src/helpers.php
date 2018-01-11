<?php

if (!function_exists('base64_url_encode')) {
    /**
     * base64 url encode
     * @param $data
     * @return mixed
     */
    function base64_url_encode($data)
    {
        return str_replace('=', '', strtr(base64_encode($data), '+/', '-_'));
    }
}

if (!function_exists('base64_url_decode')) {
    /**
     * base64 url decode
     * @param $data
     * @return bool|string
     */
    function base64_url_decode($data)
    {
        if ($remainder = strlen($data) % 4) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

if (!function_exists('create_openssl_key')) {
    /**
     * create openssl key
     * @return array
     */
    function create_openssl_key()
    {
        $res = openssl_pkey_new();

        openssl_pkey_export($res, $privateKey);

        $publicKey = openssl_pkey_get_details($res);

        $publicKey = $publicKey["key"];

        $result = openssl_pkey_get_private($privateKey);


        return ['private' => $privateKey, 'public' => $publicKey];
    }
}
