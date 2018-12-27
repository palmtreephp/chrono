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
        $precision = $precision ?? TimePeriod::SECOND;
        $options   = TimePeriod::toArray();

        if (!in_array($precision, $options)) {
            $options = implode("','", $options);
            throw new \InvalidArgumentException("Precision must be one of '$options'. '$precision' given");
        }

        switch ($precision) {
            case TimePeriod::HOUR:
                $format = 'H';
                break;
            case TimePeriod::MINUTE:
                $format = 'Hi';
                break;
            case TimePeriod::SECOND:
            default:
                $format = 'His';
                break;
        }

        return $format;
    }
}
