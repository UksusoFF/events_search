<?php

namespace App\Sources;

class DvizhSource extends JsonSource
{
    protected function getItemImage(array $item): ?string
    {
        $value = parent::getItemImage($item);

        return $value ? "https://dvizh.app/${value}" : null;
    }
}
