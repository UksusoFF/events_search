<?php

namespace App\Sources;

class VkSearchSource extends JsonSource
{
    protected function getItemUrl(array $item): ?string
    {
        $value = $this->getValueFromNotation($item, $this->config->map_id);

        return $value ? "https://vk.com/event${value}" : null;
    }
}
