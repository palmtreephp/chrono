<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\TimePeriod;

/**
 * @method self add(int $value, string $period)
 * @method self subtract(int $value, string $period)
 */
class Time extends DateTime
{
    protected function getDateInterval(int $value, string $period): \DateInterval
    {
        $intervalCode = TimePeriod::getIntervalCode($period);

        return new \DateInterval("PT$value$intervalCode");
    }

    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return TimePeriod::getDateFormat($precision ?? TimePeriod::SECOND);
    }
}
