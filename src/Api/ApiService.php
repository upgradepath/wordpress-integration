<?php

namespace Upgradepath\Api;

/**
 * Class ApiService
 */
class ApiService
{
    const API_ENDPOINT_REGISTER = 'integrations/register';
    const API_ENDPOINT_SYNC = 'integrations/sync';

    /**
     * @param string $token
     * @return array
     */
    public function register(string $token)
    {
        $request = wp_remote_post(UPGRADEPATH_API_URL.self::API_ENDPOINT_REGISTER, [
            'method' => 'POST',
            'timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'body' => wp_json_encode([
                'token' => $token,
            ]),
            'data_format' => 'body',
        ]);
        return json_decode(wp_remote_retrieve_body($request));
    }

    /**
     * @param string $apiToken
     * @param string $apiClientToken
     * @param array $software
     * @return mixed
     */
    public function sync(string $apiToken, string $apiClientToken, array $software)
    {
        $request = wp_remote_post(UPGRADEPATH_API_URL.self::API_ENDPOINT_SYNC, [
            'method' => 'POST',
            'timeout' => 2,
            'redirection' => 5,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'body' => wp_json_encode([
                'token' => $apiToken,
                'client_token' => $apiClientToken,
                'software' => $software,
            ]),
            'data_format' => 'body',
        ]);
        return json_decode(wp_remote_retrieve_body($request));
    }
}
