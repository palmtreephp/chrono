<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\TimePeriods;

/**
 * @method self add(int $value, string $period)
 * @method self subtract(int $value, string $period)
 */
class Time extends DateTime
{
    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return TimePeriods::getDateFormat($precision ?? TimePeriods::SECOND);
    }
}
