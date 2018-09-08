<?php

namespace App\Sources;

use Illuminate\Support\Carbon;

class VkCoverSource extends JsonSource
{
    protected const ID_PREFIX = 'vk_cover';

    /**
     * @param array $item
     *
     * @return \Illuminate\Support\Carbon|null
     */
    protected function getItemDate($item)
    {
        return Carbon::now()->lastOfMonth()->endOfDay();
    }

    /**
     * @param array $item
     *
     * @return null|string
     */
    protected function getItemUrl($item)
    {
        return 'https://vk.com/' . array_get($item, $this->config->map_id);
    }
}