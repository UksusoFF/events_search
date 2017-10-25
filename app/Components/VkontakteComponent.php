<?php

namespace App\Components;

use GuzzleHttp\Client;

class VkontakteComponent
{
    const BASE_API = 'https://api.vk.com/method';
    const API_VERSION = '5.68';

    private function buildApiUrl($method)
    {
        return implode('/', [
            self::BASE_API,
            $method,
        ]);
    }

    public function searchEvents(string $city = '123', array $fields = ['start_date', 'description'])
    {
        $client = new Client();

        $response = $client->get($this->buildApiUrl('groups.search'), [
            'query' => [
                'q' => '*',
                'type' => 'event',
                'city_id' => $city,
                'future' => '1',
                'market' => '0',
                'offset' => '0',
                'count' => '1000',
                'fields' => implode(',', $fields),
                'access_token' => env('VK_ACCESS_TOKEN'),
                'v' => self::API_VERSION,
            ],
        ]);

        try {
            return json_decode($response->getBody(), true)['response'];
        } catch (\Exception $e) {
            return [
                'count' => false,
                'items' => [],
            ];
        }

    }
}