<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
use Palmtree\Chrono\DateTime;
use Palmtree\Chrono\Option\DatePeriod;
use Palmtree\Chrono\Option\TimePeriod;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testToDateTime()
    {
        $date = new Date('2019-01-01');

        $dateTime = $date->toDateTime();

        $internalDateTime = $this->getPropertyValue($date, 'dateTime');

        $this->assertNotSame($dateTime, $internalDateTime);
        $this->assertEquals($internalDateTime->format(\DateTime::ATOM), $dateTime->format(\DateTime::ATOM));
    }

    public function testIsSame()
    {
        $dateTime   = new DateTime('2018-01-01 12:00:00');
        $dateTime_2 = new DateTime('2018-01-01 12:00:01');
        $dateTime_3 = new DateTime('2018-01-02 12:00:01');

        $this->assertTrue($dateTime->isSame($dateTime_2, TimePeriod::MINUTE));
        $this->assertFalse($dateTime->isSame($dateTime_2, TimePeriod::SECOND));
        $this->assertTrue($dateTime->isSame($dateTime_3, DatePeriod::MONTH));
    }

    public function testAdd()
    {
        $dateTime = new DateTime('2018-01-01 12:00:00');

        $dateTime->add(1, DatePeriod::DAY)->add(1, TimePeriod::HOUR);

        $this->assertEquals('2018-01-02 13:00:00', $dateTime->format('Y-m-d H:i:s'));
    }

    public function testSubtract()
    {
        $dateTime = new DateTime('2018-01-02 13:00:00');

        $dateTime->subtract(1, DatePeriod::DAY)->subtract(1, TimePeriod::HOUR);

        $this->assertEquals('2018-01-01 12:00:00', $dateTime->format('Y-m-d H:i:s'));
    }

    private function getPropertyValue($object, string $property)
    {
        $reflectionObject = new \ReflectionObject($object);

        $property = $reflectionObject->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
