<?php

namespace Palmtree\Chrono\Option;

abstract class AbstractPeriod
{
    abstract protected static function getIntervalCodes(): array;

    abstract protected static function getDateFormats(): array;

    public static function getIntervalCode(string $period): string
    {
        return static::getIntervalCodes()[$period];
    }

    public static function getDateFormat(string $period): string
    {
        return static::getDateFormats()[$period];
    }

    public static function toArray(): array
    {
        return array_keys(static::getIntervalCodes());
    }
}
