<?php

namespace App\Sources;

use Illuminate\Support\Carbon;

class VkCoverSource extends JsonSource
{
    protected function getItemDate(array $item): ?Carbon
    {
        return Carbon::now()->lastOfMonth()->setTime(20, 0, 0);
    }

    protected function getItemUrl(array $item): ?string
    {
        $value = parent::getItemUrl($item);

        return $value ? "https://vk.com/${value}" : null;
    }
}
