<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Option\DatePeriods;
use Palmtree\Chrono\Option\TimePeriods;

class DateTime extends Date
{
    public function __construct(string $time = 'now', $timezone = null)
    {
        $this->dateTime = $this->createInternalDateTime($time, $timezone);
    }

    public function setTime(int $hour, int $minute, int $second = 0, int $microseconds = 0): self
    {
        $this->dateTime->setTime($hour, $minute, $second, $microseconds);

        return $this;
    }

    public function setHour(int $hour): self
    {
        return $this->setTime($hour, $this->dateTime->format('i'), $this->dateTime->format('s'), $this->dateTime->format('u'));
    }

    public function setMinute(int $minute): self
    {
        return $this->setTime($this->dateTime->format('H'), $minute, $this->dateTime->format('s'), $this->dateTime->format('u'));
    }

    public function setSecond(int $second): self
    {
        return $this->setTime($this->dateTime->format('H'), $this->dateTime->format('i'), $second, $this->dateTime->format('u'));
    }

    public function setMicroseconds(int $microseconds): self
    {
        return $this->setTime($this->dateTime->format('H'), $this->dateTime->format('i'), $this->dateTime->format('s'), $microseconds);
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
}
