<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
use Palmtree\Chrono\Option\DatePeriod;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testIsToday()
    {
        $today     = new Date('now');
        $tomorrow  = new Date('tomorrow');
        $yesterday = new Date('yesterday');

        $this->assertTrue($today->isToday());
        $this->assertFalse($tomorrow->isToday());
        $this->assertFalse($yesterday->isToday());
    }

    public function testIsSameMonth()
    {
        $firstJan  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');
        $firstFeb  = new Date('2018-02-01');

        $this->assertTrue($firstJan->isSame($secondJan, DatePeriod::MONTH));
        $this->assertFalse($firstJan->isSame($firstFeb, DatePeriod::MONTH));
    }

    public function testIsSameYear()
    {
        $firstJan = new Date('2018-01-01');
        $lastDec  = new Date('2018-12-31');

        $this->assertTrue($firstJan->isSame($lastDec, DatePeriod::YEAR));
    }

    public function testIsBefore()
    {
        $firstJan  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');

        $this->assertTrue($firstJan->isBefore($secondJan));
        $this->assertFalse($secondJan->isBefore($firstJan));
    }

    public function testIsAfter()
    {
        $firstJan  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');

        $this->assertTrue($secondJan->isAfter($firstJan));
        $this->assertFalse($firstJan->isAfter($secondJan));
    }

    public function testAdd()
    {
        $date = new Date('2018-01-01');

        $date->add(1, DatePeriod::DAY);

        $this->assertEquals('2018-01-02', $date->format('Y-m-d'));

        $date->add(1, DatePeriod::YEAR);

        $this->assertEquals('2019-01-02', $date->format('Y-m-d'));
    }

    public function testSubtract()
    {
        $date = new Date('2019-01-01');

        $date->subtract(1, DatePeriod::DAY);

        $this->assertEquals('2018-12-31', $date->format('Y-m-d'));

        $date->subtract(1, DatePeriod::YEAR);

        $this->assertEquals('2017-12-31', $date->format('Y-m-d'));
    }

    public function testMin()
    {
        $firstJan  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');

        $dates = [$firstJan, $secondJan];

        $min = Date::min(...$dates);

        $this->assertSame($firstJan, $min);
    }

    public function testMax()
    {
        $firstJan  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');

        $dates = [$firstJan, $secondJan];

        $max = Date::max(...$dates);

        $this->assertSame($secondJan, $max);
    }
}
