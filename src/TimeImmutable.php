<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\TimePeriods;

class TimeImmutable extends DateTimeImmutable
{
    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return TimePeriods::getDateFormat($precision ?? TimePeriods::SECOND);
    }
}
