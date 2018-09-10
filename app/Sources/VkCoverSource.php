<?php

namespace App\Sources;

use Illuminate\Support\Carbon;

class VkCoverSource extends JsonSource
{
    /**
     * @param array $item
     *
     * @return \Illuminate\Support\Carbon|null
     */
    protected function getItemDate($item)
    {
        return Carbon::now()->lastOfMonth()->setTime(20, 0, 0);
    }

    /**
     * @param array $item
     *
     * @return null|string
     */
    protected function getItemUrl($item)
    {
        return 'https://vk.com/' . array_get($item, $this->config->map_url);
    }
}