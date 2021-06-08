<?php

namespace App\Sources;

class DvizhSource extends JsonSource
{
    protected function getItemUrl(array $item): ?string
    {
        return $this->config->source;
    }
}
