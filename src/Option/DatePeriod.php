<?php

namespace Palmtree\Chrono\Option;

abstract class DatePeriod extends AbstractPeriod
{
    public const YEAR = 'year';
    public const MONTH = 'month';
    public const DAY = 'day';

    protected static function getIntervalCodes(): array
    {
        return [
            self::YEAR  => 'Y',
            self::MONTH => 'M',
            self::DAY   => 'D',
        ];
    }
}
