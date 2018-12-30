<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\TimePeriods;

/**
 * @method self   add(int $value, string $period)
 * @method self   subtract(int $value, string $period)
 * @method self   setTime(int $hour, int $minute, int $second = 0, int $microseconds = 0)
 * @method self   setHour(int $hour)
 * @method self   setMinute(int $minute)
 * @method self   setSecond(int $second)
 * @method self   setMicroseconds(int $microseconds)
 * @method self   fromNative(\DateTime $dateTime)
 * @method static null|self min(...$dates)
 * @method static null|self max(...$dates)
 */
class Time extends DateTime
{
    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return TimePeriods::getDateFormat($precision ?? TimePeriods::SECOND);
    }
}
