<?php

declare(strict_types=1);

namespace Helper;

class StringHelper
{
    private const BAD_WORDS = [
        "naxui", "blet", "bled", "kurva", "kurwa", "titas abramavičius", "bybi"
    ];

    public static function filterBadWords(string $string): string
    {
        return str_ireplace(self::BAD_WORDS, "***", $string);
    }
}