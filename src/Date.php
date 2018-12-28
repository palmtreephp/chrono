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
            self::$today = new self('now', $this->dateTime->getTimezone());
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
        return DatePeriod::getDateFormat($precision ?? DatePeriod::DAY);
    }
}
