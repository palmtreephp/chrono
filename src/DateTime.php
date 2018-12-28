<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\ComparisonOperators;
use Palmtree\Chrono\Option\DatePeriods;
use Palmtree\Chrono\Option\TimePeriods;

class DateTime
{
    /** @var \DateTime */
    protected $dateTime;

    public function __construct(string $time = 'now', $timezone = null)
    {
        if (\is_string($timezone)) {
            $timezone = new \DateTimeZone($timezone);
        }

        $this->dateTime = new \DateTime($time, $timezone);
    }

    public function format(string $format): string
    {
        return $this->dateTime->format($format);
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

    public function add(int $value, string $period): self
    {
        $this->dateTime->add($this->getDateInterval($value, $period));

        return $this;
    }

    public function subtract(int $value, string $period): self
    {
        $this->dateTime->sub($this->getDateInterval($value, $period));

        return $this;
    }

    public function toDateTime(): \DateTime
    {
        return clone $this->dateTime;
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
        try {
            $format = TimePeriods::getDateFormat($precision ?? TimePeriods::SECOND);
        } catch (\InvalidArgumentException $e) {
            $format = DatePeriods::getDateFormat($precision ?? DatePeriods::DAY);
        }

        return $format;
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
}
