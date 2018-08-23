<?php

namespace App\Sources;

use App\Models\Source;
use Carbon\Carbon;
use GuzzleHttp\Client;

class JsonSource implements SourceInterface
{
    private $config;

    private $client;

    public function __construct(Source $source)
    {
        $this->config = $source;
        $this->client = new Client();
    }

    public function getEvents()
    {
        $array = json_decode($this->client->get($this->config->source)->getBody(), true);

        $items = array_get($array, $this->config->map_items, []);

        return collect(array_map(function ($item) {
            $date = array_get($item, $this->config->map_date);
            return [
                'id' => array_get($item, $this->config->map_id),
                'title' => array_get($item, $this->config->map_title),
                'desc' => array_get($item, $this->config->map_desc),
                'image' => array_get($item, $this->config->map_image),
                'date' => $this->config->map_date_format === 'timestamp' ?
                    Carbon::createFromTimestamp($date) :
                    Carbon::createFromFormat($date, $this->config->map_date_format),
            ];
        }, $items));
    }
}