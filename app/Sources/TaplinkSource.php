<?php

namespace App\Sources;

class TaplinkSource extends JsonSource
{

    protected function getSources(): array
    {
        $base = $this->config->source;
        $sources = [
            $base,
        ];

        $i = 1;

        foreach (range(1, 10) as $step) {
            $i += 12;

            $sources[] = "{$base}?" . http_build_query([
                'next' => $i,
            ]);
        }

        return $sources;
    }

    protected function getItemImage(array $item): ?string
    {
        $value = $this->getValueFromNotation($item, $this->config->map_image);

        return $value ? "https://s.taplink.ru/p/${value}" : null;
    }
}
