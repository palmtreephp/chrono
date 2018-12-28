<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\Date;
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

    private function getPropertyValue($object, string $property)
    {
        $reflectionObject = new \ReflectionObject($object);
        $property         = $reflectionObject->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
