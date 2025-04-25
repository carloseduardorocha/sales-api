<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class CacheKey
{
    /**
     * Sanitize cache key
     *
     * @param string $cache_key
     * @return string
     */
    public static function sanitize(string $cache_key): string
    {
        return Str::upper(Str::replace(['-', ':', ' ', '.'], '_', $cache_key));
    }
}
