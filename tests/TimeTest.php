<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
use Palmtree\Chrono\Option\DatePeriods;
use Palmtree\Chrono\Option\TimePeriods;
use Palmtree\Chrono\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testIsSameHour()
    {
        $twelve01 = new Time('12:01');
        $twelve02 = new Time('12:02');
        $one01    = new Time('13:01');

        $this->assertTrue($twelve01->isSame($twelve02, TimePeriods::HOUR));
        $this->assertFalse($twelve01->isSame($one01, TimePeriods::HOUR));
    }

    public function testIsSameMinute()
    {
        $twelve0101 = new Time('12:01:01');
        $twelve0102 = new Time('12:01:02');
        $twelve0201 = new Time('12:02:01');

        $this->assertTrue($twelve0101->isSame($twelve0102, TimePeriods::MINUTE));
        $this->assertFalse($twelve0101->isSame($twelve0201, TimePeriods::MINUTE));
    }

    public function testIsSameSecond()
    {
        $twelve0101   = new Time('12:01:01');
        $twelve0101_2 = new Time('12:01:01');
        $twelve0102   = new Time('12:01:02');

        $this->assertTrue($twelve0101->isSame($twelve0101_2, TimePeriods::SECOND));
        $this->assertFalse($twelve0101->isSame($twelve0102, TimePeriods::SECOND));
    }

    public function testAdd()
    {
        $time = new Time('12:00:00');

        $time->add(1, TimePeriods::HOUR)->add(10, TimePeriods::MINUTE);

        $this->assertEquals('13:10:00', $time->format('H:i:s'));
    }

    public function testSubtract()
    {
        $time = new Time('13:10:00');

        $time->subtract(1, TimePeriods::HOUR)->subtract(10, TimePeriods::MINUTE);

        $this->assertEquals('12:00:00', $time->format('H:i:s'));
    }

    public function testMin()
    {
        $twelve = new Time('12:00:00');
        $one    = new Time('13:00:00');

        $min = Time::min(...[$twelve, $one]);

        $this->assertSame($twelve, $min);
    }

    public function testMax()
    {
        $twelve = new Time('12:00:00');
        $one    = new Time('13:00:00');

        $max = Time::max($twelve, $one);

        $this->assertSame($one, $max);
    }
}
