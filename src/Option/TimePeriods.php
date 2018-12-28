<?php

namespace Palmtree\Chrono\Option;

abstract class TimePeriods extends AbstractPeriods
{
    public const HOUR   = 'hour';
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

    protected static function getDateFormats(): array
    {
        return [
            self::HOUR   => 'H',
            self::MINUTE => 'Hi',
            self::SECOND => 'His',
        ];
    }
}
