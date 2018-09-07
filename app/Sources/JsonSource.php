<?php

namespace App\Sources;

use App\Helpers\DateTimeHelper;
use App\Models\Source;
use GuzzleHttp\Client;

class JsonSource implements SourceInterface
{
    protected $config;

    protected $client;

    protected $dateTimeHelper;

    protected const ID_PREFIX = 'json';

    public function __construct(Source $source)
    {
        $this->config = $source;
        $this->client = new Client();
        $this->dateTimeHelper = new DateTimeHelper();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getEvents()
    {
        $array = json_decode($this->client->get($this->config->source)->getBody(), true);

        $items = array_get($array, $this->config->map_items, []);

        return collect(array_map(function ($item) {
            return [
                'uuid' => $this->getItemUuid($item),
                'title' => array_get($item, $this->config->map_title),
                'url' => $this->getItemUrl($item),
                'description' => array_get($item, $this->config->map_description),
                'image' => array_get($item, $this->config->map_image),
                'date' => $this->getItemDate($item),
            ];
        }, $items));
    }

    /**
     * @param array $item
     *
     * @return null|string
     */
    protected function getItemUuid(array $item)
    {
        if (empty($this->config->map_id)) {
            return null;
        }

        if (empty($itemValue = array_get($item, $this->config->map_id))) {
            return null;
        }

        return implode('_', [
            self::ID_PREFIX,
            $this->config->id,
            md5($itemValue),
        ]);
    }

    /**
     * @param array $item
     *
     * @return \Carbon\Carbon|null
     */
    protected function getItemDate($item)
    {
        if (empty($this->config->map_date)) {
            return null;
        }

        if (empty($itemValue = array_get($item, $this->config->map_date))) {
            return null;
        }

        return $this->dateTimeHelper->getDateFromFormat(
            $itemValue,
            $this->config->map_date_format,
            $this->config->map_date_regex
        );
    }

    /**
     * @param array $item
     *
     * @return null|string
     */
    protected function getItemUrl($item)
    {
        return array_get($item, $this->config->map_url);
    }
}