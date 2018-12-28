<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\Comparision;

abstract class DateTime
{
    /** @var \DateTime */
    protected $dateTime;

    public function __construct(string $time = 'now', $timezone = null)
    {
        if (is_string($timezone)) {
            $timezone = new \DateTimeZone($timezone);
        }

        $this->dateTime = new \DateTime($time, $timezone);
    }

    abstract protected function getFormatFromTimePrecision(?string $precision);

    abstract protected function getDateInterval(int $value, string $period): \DateInterval;

    public function format(string $format): string
    {
        return $this->dateTime->format($format);
    }

    public function isSame(DateTime $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, Comparision::EQUAL_TO, $precision);
    }

    public function isBefore(DateTime $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, Comparision::LESS_THAN, $precision);
    }

    public function isSameOrBefore(DateTime $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, Comparision::LESS_THAN_OR_EQUAL_TO, $precision);
    }

    public function isAfter(DateTime $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, Comparision::GREATER_THAN, $precision);
    }

    public function isSameOrAfter(DateTime $date, ?string $precision = null): bool
    {
        return $this->compareTo($date, Comparision::GREATER_THAN_OR_EQUAL_TO, $precision);
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

    public static function min(...$dates): ?DateTime
    {
        return \array_reduce($dates, function (?DateTime $carry, DateTime $dateTime) {
            if (!$carry || $dateTime->isBefore($carry)) {
                $carry = $dateTime;
            }

            return $carry;
        });
    }

    public static function max(...$dates): ?DateTime
    {
        return \array_reduce($dates, function (?DateTime $carry, DateTime $dateTime) {
            if (!$carry || $dateTime->isAfter($carry)) {
                $carry = $dateTime;
            }

            return $carry;
        });
    }

    private function compareTo(DateTime $date, string $operator, ?string $precision = null): bool
    {
        $operators = Comparision::toArray();
        if (!in_array($operator, $operators)) {
            $operators = implode("','", $operators);
            throw new \InvalidArgumentException("Operator must be one of '$operators'. $operator given");
        }

        $format = $this->getFormatFromTimePrecision($precision);

        $thisFormatted = (int)$this->format($format);
        $dateFormatted = (int)$date->format($format);

        switch ($operator) {
            case Comparision::LESS_THAN:
                $result = $thisFormatted < $dateFormatted;
                break;
            case Comparision::GREATER_THAN:
                $result = $thisFormatted > $dateFormatted;
                break;
            case Comparision::LESS_THAN_OR_EQUAL_TO:
                $result = $thisFormatted <= $dateFormatted;
                break;
            case Comparision::GREATER_THAN_OR_EQUAL_TO:
                $result = $thisFormatted >= $dateFormatted;
                break;
            case Comparision::EQUAL_TO:
            default:
                $result = $thisFormatted === $dateFormatted;
                break;
        }

        return $result;
    }
}
