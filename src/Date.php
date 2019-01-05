<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\ComparisonOperators;
use Palmtree\Chrono\Option\DatePeriods;
use Palmtree\Chrono\Option\TimePeriods;

class Date
{
    /** @var \DateTime */
    protected $dateTime;

    public function __construct(string $time = 'now', $timezone = null)
    {
        $this->dateTime = $this->createInternalDateTime($time, $timezone);

        $this->dateTime->setTime(0, 0);
    }

    public static function fromNative(\DateTime $dateTime): self
    {
        return new static($dateTime->format('Y-m-d H:i:s.u'), $dateTime->getTimezone());
    }

    public function toNative(): \DateTime
    {
        return clone $this->dateTime;
    }

    public function format(?string $format = null): string
    {
        return $this->dateTime->format($format ?? \DateTime::ISO8601);
    }

    public function isToday(): bool
    {
        $today = new self('now', $this->dateTime->getTimezone());

        return $this->isSame($today, DatePeriods::DAY);
    }

    public function isSame(self $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, ComparisonOperators::EQUAL_TO, $precision);
    }

    public function isBefore(self $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, ComparisonOperators::LESS_THAN, $precision);
    }

    public function isSameOrBefore(self $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, ComparisonOperators::LESS_THAN_OR_EQUAL_TO, $precision);
    }

    public function isAfter(self $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, ComparisonOperators::GREATER_THAN, $precision);
    }

    public function isSameOrAfter(self $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, ComparisonOperators::GREATER_THAN_OR_EQUAL_TO, $precision);
    }

    /**
     * @param int    $value
     * @param string $period
     *
     * @return self
     */
    public function add(int $value, string $period)
    {
        $this->dateTime->add($this->getDateInterval($value, $period));

        return $this;
    }

    /**
     * @param int    $value
     * @param string $period
     *
     * @return self
     */
    public function subtract(int $value, string $period)
    {
        $this->dateTime->sub($this->getDateInterval($value, $period));

        return $this;
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

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return self
     */
    public function setDate(int $year, int $month, int $day)
    {
        $this->dateTime->setDate($year, $month, $day);

        return $this;
    }

    public function createClone()
    {
        return clone $this;
    }

    public function __clone()
    {
        $this->dateTime = clone $this->dateTime;
    }

    public static function min(...$dates): ?self
    {
        return \array_reduce($dates, function (?self $carry, self $dateTime) {
            if (!$carry || $dateTime->isBefore($carry)) {
                $carry = $dateTime;
            }

            return $carry;
        });
    }

    public static function max(...$dates): ?self
    {
        return \array_reduce($dates, function (?self $carry, self $dateTime) {
            if (!$carry || $dateTime->isAfter($carry)) {
                $carry = $dateTime;
            }

            return $carry;
        });
    }

    protected function getFormatFromTimePrecision(?string $precision): string
    {
        return DatePeriods::getDateFormat($precision ?? DatePeriods::DAY);
    }

    protected function getDateInterval(int $value, string $period): \DateInterval
    {
        try {
            $intervalCode = TimePeriods::getIntervalCode($period);
            $prefix       = 'PT';
        } catch (\InvalidArgumentException $e) {
            $intervalCode = DatePeriods::getIntervalCode($period);
            $prefix       = 'P';
        }

        return new \DateInterval("$prefix$value$intervalCode");
    }

    private function compareTo(self $date, string $operator, ?string $precision = null): bool
    {
        $format = $this->getFormatFromTimePrecision($precision);

        return \version_compare((int)$this->format($format), (int)$date->format($format), $operator);
    }

    protected function createInternalDateTime(string $time = 'now', $timezone = null)
    {
        if (\is_string($timezone)) {
            $timezone = new \DateTimeZone($timezone);
        }

        return new \DateTime($time, $timezone);
    }
}
