<?php

namespace LongTailVentures;

class StringUtils
{
    /*
     * re: http://www.jonasjohn.de/snippets/php/starts-with.htm
     */
    public static function startsWith($haystack, $needle)
    {
        return strpos($haystack, $needle) === 0;
    }


    /*
     * re: http://www.jonasjohn.de/snippets/php/ends-with.htm
    */
    public static function endsWith($haystack, $needle)
    {
        return strrpos((string)$haystack, (string)$needle) === strlen((string)$haystack)-strlen((string)$needle);
    }
}