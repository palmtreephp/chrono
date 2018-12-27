<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
use Palmtree\Chrono\Option\DatePeriod;
use Palmtree\Chrono\Option\TimePeriod;
use Palmtree\Chrono\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testIsSameHour()
    {
        $twelve01 = new Time('12:01');
        $twelve02 = new Time('12:02');
        $one01    = new Time('13:01');

        $this->assertTrue($twelve01->isSame($twelve02, TimePeriod::HOUR));
        $this->assertFalse($twelve01->isSame($one01, TimePeriod::HOUR));
    }

    public function testIsSameMinute()
    {
        $twelve0101 = new Time('12:01:01');
        $twelve0102 = new Time('12:01:02');
        $twelve0201 = new Time('12:02:01');

        $this->assertTrue($twelve0101->isSame($twelve0102, TimePeriod::MINUTE));
        $this->assertFalse($twelve0101->isSame($twelve0201, TimePeriod::MINUTE));
    }

    public function testIsSameSecond()
    {
        $twelve0101   = new Time('12:01:01');
        $twelve0101_2 = new Time('12:01:01');
        $twelve0102   = new Time('12:01:02');

        $this->assertTrue($twelve0101->isSame($twelve0101_2, TimePeriod::SECOND));
        $this->assertFalse($twelve0101->isSame($twelve0102, TimePeriod::SECOND));
    }

    public function testAdd()
    {
        $time = new Time('12:00:00');

        $time->add(1, TimePeriod::HOUR)->add(10, TimePeriod::MINUTE);

        $this->assertEquals('13:10:00', $time->format('H:i:s'));
    }

    public function testSubtract()
    {
        $time = new Time('13:10:00');

        $time->subtract(1, TimePeriod::HOUR)->subtract(10, TimePeriod::MINUTE);

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
