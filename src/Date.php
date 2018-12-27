<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\DatePeriod;

/**
 * @method self add(int $value, string $period)
 * @method self subtract(int $value, string $period)
 */
class Date extends DateTime
{
    /** @var Date */
    private static $today;

    public function __construct(string $time = 'now', $timezone = null)
    {
        parent::__construct($time, $timezone);

        $this->dateTime->setTime(0, 0);
    }

    public function isToday(): bool
    {
        if (is_null(self::$today)) {
            self::$today = new self();
        }

        return $this->isSame(self::$today, DatePeriod::DAY);
    }

    protected function getDateInterval(int $value, string $period): \DateInterval
    {
        $intervalCode = DatePeriod::getIntervalCode($period);

        return new \DateInterval("P$value$intervalCode");
    }

    protected function getFormatFromTimePrecision(?string $precision): string
    {
        $precision = $precision ?? DatePeriod::DAY;
        $options   = DatePeriod::toArray();

        if (!in_array($precision, $options)) {
            $options = implode("','", $options);
            throw new \InvalidArgumentException("Precision must be one of '$options'. '$precision' given");
        }

        switch ($precision) {
            case DatePeriod::YEAR:
                $format = 'Y';
                break;
            case DatePeriod::MONTH:
                $format = 'Ym';
                break;
            case DatePeriod::DAY:
            default:
                $format = 'Ymd';
                break;
        }

        return $format;
    }
}
