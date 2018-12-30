<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
use Palmtree\Chrono\DateTime;
use Palmtree\Chrono\Option\DatePeriods;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testIsToday()
    {
        $today     = new Date('now', 'Europe/London');
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

        $this->assertTrue($firstJan->isSame($secondJan, DatePeriods::MONTH));
        $this->assertFalse($firstJan->isSame($firstFeb, DatePeriods::MONTH));
    }

    public function testIsSameYear()
    {
        $firstJan = new Date('2018-01-01');
        $lastDec  = new Date('2018-12-31');

        $this->assertTrue($firstJan->isSame($lastDec, DatePeriods::YEAR));
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

    public function testIsSameOrBefore()
    {
        $firstJan  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');
        $secondJan_2 = new Date('2018-01-02');

        $this->assertTrue($firstJan->isSameOrBefore($secondJan));
        $this->assertTrue($secondJan_2->isSameOrBefore($secondJan));
        $this->assertFalse($secondJan->isSameOrBefore($firstJan));
    }

    public function testIsSameOrAfter()
    {
        $firstJan  = new Date('2018-01-01');
        $firstJan_2  = new Date('2018-01-01');
        $secondJan = new Date('2018-01-02');

        $this->assertTrue($secondJan->isSameOrAfter($firstJan));
        $this->assertTrue($firstJan_2->isSameOrAfter($firstJan));
        $this->assertFalse($firstJan->isSameOrAfter($secondJan));
    }

    public function testAdd()
    {
        $date = new Date('2018-01-01');

        $date->add(1, DatePeriods::DAY);

        $this->assertEquals('2018-01-02', $date->format('Y-m-d'));

        $date->add(1, DatePeriods::YEAR);

        $this->assertEquals('2019-01-02', $date->format('Y-m-d'));
    }

    public function testSubtract()
    {
        $date = new Date('2019-01-01');

        $date->subtract(1, DatePeriods::DAY);

        $this->assertEquals('2018-12-31', $date->format('Y-m-d'));

        $date->subtract(1, DatePeriods::YEAR);

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

    public function testToNative()
    {
        $date = new Date('2019-01-01');

        $dateTime = $date->toNative();

        $internalDateTime = $this->getPropertyValue($date, 'dateTime');

        $this->assertNotSame($dateTime, $internalDateTime);
        $this->assertEquals($internalDateTime->format(\DateTime::ATOM), $dateTime->format(\DateTime::ATOM));
    }

    public function testFromNative()
    {
        $native = new \DateTime('2019-01-01 12:30:45.123456');

        $dateTime = DateTime::fromNative($native);

        $this->assertNotSame($native, $dateTime->toNative());
        $this->assertEquals($dateTime->toNative()->getTimestamp(), $native->getTimestamp());
        $this->assertEquals('2019-01-01 12:30:45.123456', $dateTime->format('Y-m-d H:i:s.u'));
    }

    /** @expectedException \InvalidArgumentException */
    public function testInvalidPrecision()
    {
        $date = new Date('2019-01-01');

        $date->isSame(new Date(), 'foo');
    }

    private function getPropertyValue($object, string $property)
    {
        $reflectionObject = new \ReflectionObject($object);

        $property = $reflectionObject->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
