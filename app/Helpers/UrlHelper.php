<?php

namespace App\Helpers;

class UrlHelper
{
    public static function relToAbs(string $uri, string $src): string
    {
        if (starts_with($uri, [
            'http',
            'https',
        ])) {
            return $uri;
        }

        $base = parse_url($src);

        return "{$base['scheme']}://{$base['host']}/" . trim($uri, '/');
    }
}