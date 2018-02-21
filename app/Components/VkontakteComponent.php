<?php

namespace App\Components;

use Exception;
use GuzzleHttp\Client;

class VkontakteComponent
{
    const BASE_API_URL = 'https://api.vk.com/method';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    private function buildApiUrl(string $method)
    {
        return implode('/', [
            self::BASE_API_URL,
            $method,
        ]);
    }

    /**
     * @param string $method
     * @param array $query
     * @return mixed
     * @throws Exception
     */
    private function get(string $method, array $query)
    {
        $response = json_decode($this->client->get($this->buildApiUrl($method), [
            'query' => array_merge($query, [
                'v' => config('services.vkontakte.version'),
            ]),
        ])->getBody(), true);

        if (isset($response['error'])) {
            throw new Exception('VK Api Error: ' . $response['error']['error_msg']);
        }

        return $response['response'];
    }

    /**
     * @param string $city
     * @param array $fields
     * @return mixed
     * @throws Exception
     */
    public function searchEvents(string $city, array $fields = ['start_date', 'description'])
    {
        return $this->get('groups.search', [
            'q' => '*',
            'type' => 'event',
            'city_id' => $city,
            'future' => '1',
            'market' => '0',
            'offset' => '0',
            'count' => '1000',
            'fields' => implode(',', $fields),
            'access_token' => env('VK_ACCESS_TOKEN'),
        ])['items'];
    }
}