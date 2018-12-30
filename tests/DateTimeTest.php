<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
use Palmtree\Chrono\DateTime;
use Palmtree\Chrono\Option\DatePeriods;
use Palmtree\Chrono\Option\TimePeriods;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testIsSame()
    {
        $dateTime   = new DateTime('2018-01-01 12:00:00');
        $dateTime_2 = new DateTime('2018-01-01 12:00:01');
        $dateTime_3 = new DateTime('2018-01-02 12:00:01');

        $this->assertTrue($dateTime->isSame($dateTime_2, TimePeriods::MINUTE));
        $this->assertFalse($dateTime->isSame($dateTime_2, TimePeriods::SECOND));
        $this->assertTrue($dateTime->isSame($dateTime_3, DatePeriods::MONTH));
    }

    public function testAdd()
    {
        $dateTime = new DateTime('2018-01-01 12:00:00');

        $dateTime->add(1, DatePeriods::DAY)->add(1, TimePeriods::HOUR);

        $this->assertEquals('2018-01-02 13:00:00', $dateTime->format('Y-m-d H:i:s'));
    }

    public function testSubtract()
    {
        $dateTime = new DateTime('2018-01-02 13:00:00');

        $dateTime->subtract(1, DatePeriods::DAY)->subtract(1, TimePeriods::HOUR);

        $this->assertEquals('2018-01-01 12:00:00', $dateTime->format('Y-m-d H:i:s'));
    }
}
