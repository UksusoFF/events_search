<?php

namespace App\Sources;

class VkSearchSource extends JsonSource
{
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