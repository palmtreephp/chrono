<?php

namespace Palmtree\Chrono\Option;

abstract class DatePeriods extends AbstractPeriods
{
    public const YEAR  = 'year';
    public const MONTH = 'month';
    public const DAY   = 'day';

    protected static function getIntervalCodes(): array
    {
        return [
            self::YEAR  => 'Y',
            self::MONTH => 'M',
            self::DAY   => 'D',
        ];
    }

    protected static function getDateFormats(): array
    {
        return [
            self::YEAR  => 'Y',
            self::MONTH => 'Ym',
            self::DAY   => 'Ymd',
        ];
    }
}
