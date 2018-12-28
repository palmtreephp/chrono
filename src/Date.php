<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\DatePeriods;

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
        if (self::$today === null) {
            self::$today = new self('now', $this->dateTime->getTimezone());
        }

        return $this->isSame(self::$today, DatePeriods::DAY);
    }

    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return DatePeriods::getDateFormat($precision ?? DatePeriods::DAY);
    }
}
