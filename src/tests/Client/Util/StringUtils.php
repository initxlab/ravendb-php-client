<?php

namespace RavenDB\Tests\Client\Util;

final class StringUtils
{
    public static function isBlank($string): bool
    {
        return empty($string);
    }

    public static function equalsIgnoreCase(string $var1, string $var2): bool
    {
        return (strcasecmp($var1, $var2) == 0) ?? false;
    }
}