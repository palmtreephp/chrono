<?php

namespace Palmtree\Chrono;

use Palmtree\Chrono\Traits\Immutable;

class DateImmutable extends Date
{
    use Immutable;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return self
     */
    public function setDate(int $year, int $month, int $day)
    {
        return $this->cloneCall(__FUNCTION__, \func_get_args());
    }
}
