<?php

namespace App\Sources;

use Illuminate\Support\Carbon;

class VkSearchSource extends JsonSource
{
    protected function getItemUrl(array $item): ?string
    {
        $value = $this->getValueFromNotation($item, $this->config->map_id);

        return $value ? "https://vk.com/event${value}" : null;
    }

    protected function getItemDate(array $item): ?Carbon
    {
        if (empty($this->config->map_date)) {
            return null;
        }

        if (empty($itemValue = $this->getValueFromNotation($item, $this->config->map_date))) {
            return null;
        }

        if (starts_with($itemValue, '-')) {
            return null;
        }

        return $this->dateTimeHelper->getDateFromFormat(
            $itemValue,
            $this->config->map_date_format,
            $this->config->map_date_regex
        );
    }

}
