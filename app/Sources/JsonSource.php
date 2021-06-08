<?php

namespace App\Sources;

use App\Helpers\DateTimeHelper;
use App\Models\Source;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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

    protected function getSources(): array {
        return (explode('|', $this->config->source));
    }

    public function getEvents(): Collection
    {
        $events = collect();

        foreach ($this->getSources() as $source) {
            $array = json_decode($this->client->get($source)->getBody(), true);

            $items = array_get($array, $this->config->map_items, []);

            foreach ($items as $item) {
                $events->push([
                    'uuid' => $this->getItemUuid($item),
                    'title' => $this->getValueFromNotation($item, $this->config->map_title),
                    'url' => $this->getItemUrl($item),
                    'description' => $this->getValueFromNotation($item, $this->config->map_description),
                    'image' => $this->getItemImage($item),
                    'date' => $this->getItemDate($item),
                ]);
            }
        }

        return $events;
    }

    protected function getItemUuid(array $item): ?string
    {
        if (empty($this->config->map_id)) {
            return null;
        }

        if (empty($itemValue = $this->getValueFromNotation($item, $this->config->map_id))) {
            return null;
        }

        return implode('_', [
            self::ID_PREFIX,
            $this->config->id,
            md5($itemValue),
        ]);
    }

    protected function getItemDate(array $item): ?Carbon
    {
        if (empty($this->config->map_date)) {
            return null;
        }

        if (empty($itemValue = $this->getValueFromNotation($item, $this->config->map_date))) {
            return null;
        }

        return $this->dateTimeHelper->getDateFromFormat(
            $itemValue,
            $this->config->map_date_format,
            $this->config->map_date_regex
        );
    }

    protected function getItemUrl(array $item): ?string
    {
        return $this->getValueFromNotation($item, $this->config->map_url);
    }

    protected function getItemImage(array $item): ?string
    {
        return $this->getValueFromNotation($item, $this->config->map_image);
    }

    protected function getValueFromNotation(array $item, string $notation): ?string
    {
        if (empty($notation)) {
            return null;
        }

        $data = data_get($item, $notation, []);

        if (is_array($data)) {
            return last($data);
        }

        return $data;
    }
}
