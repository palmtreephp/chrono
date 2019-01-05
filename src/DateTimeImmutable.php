<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Traits\Immutable;

class DateTimeImmutable extends DateTime
{
    use Immutable;

    public function setTime(int $hour, int $minute, int $second = 0, int $microseconds = 0): DateTime
    {
        return $this->cloneCall(__FUNCTION__, \func_get_args());
    }
}
