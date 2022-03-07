<?php

namespace Helper;

class StringHelper
{
    private const BAD_WORDS = [
        "naxui", "blet", "bled", "kurva", "kurwa", "titas abramavičius", "bybi"
    ];

    public static function filterBadWords($string)
    {
        return str_ireplace(self::BAD_WORDS, "***", $string);
    }
}