<?php

namespace App\Sources;

class VkSource extends JsonSource
{
    protected const ID_PREFIX = 'vk';

    /**
     * @param array $item
     *
     * @return null|string
     */
    protected function getItemUrl($item)
    {
        return 'https://vk.com/event' . array_get($item, $this->config->map_id);
    }
}