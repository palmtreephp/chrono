<?php

namespace Palmtree\Chrono\Option;

abstract class TimePeriod extends AbstractPeriod
{
    public const HOUR = 'hour';
    public const MINUTE = 'minute';
    public const SECOND = 'second';

    protected static function getIntervalCodes(): array
    {
        return [
            self::HOUR   => 'H',
            self::MINUTE => 'M',
            self::SECOND => 'S',
        ];
    }
}
