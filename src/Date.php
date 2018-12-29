<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\DatePeriods;

/**
 * @method self add(int $value, string $period)
 * @method self subtract(int $value, string $period)
 */
class Date extends DateTime
{
    public function __construct(string $time = 'now', $timezone = null)
    {
        parent::__construct($time, $timezone);

        $this->dateTime->setTime(0, 0);
    }

    public function isToday(): bool
    {
        $today = new self('now', $this->dateTime->getTimezone());

        return $this->isSame($today, DatePeriods::DAY);
    }

    public function setYear(int $year): self
    {
        return $this->setDate($year, $this->dateTime->format('m'), $this->dateTime->format('d'));
    }

    public function setMonth(int $month): self
    {
        return $this->setDate($this->dateTime->format('Y'), $month, $this->dateTime->format('d'));
    }

    public function setDay(int $day): self
    {
        return $this->setDate($this->dateTime->format('Y'), $this->dateTime->format('m'), $day);
    }

    public function setDate(int $year, int $month, int $day): self
    {
        $this->dateTime->setDate($year, $month, $day);

        return $this;
    }

    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return DatePeriods::getDateFormat($precision ?? DatePeriods::DAY);
    }
}
