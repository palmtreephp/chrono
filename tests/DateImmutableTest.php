<?php

namespace Palmtree\Chrono\Tests;

use Palmtree\Chrono\DateImmutable;
use Palmtree\Chrono\Option\DatePeriods;
use Palmtree\Chrono\Tests\Util\PropertyAccessor;
use PHPUnit\Framework\TestCase;

class DateImmutableTest extends TestCase
{
    public function testAdd()
    {
        $date = new DateImmutable('2019-01-01');

        $newDate = $date->add(1, DatePeriods::DAY);

        $this->assertNotSame($date, $newDate);
        $this->assertNotSame(PropertyAccessor::getPropertyValue($date, 'dateTime'), PropertyAccessor::getPropertyValue($newDate, 'dateTime'));

        $this->assertEquals('2019-01-01', $date->format('Y-m-d'));
        $this->assertEquals('2019-01-02', $newDate->format('Y-m-d'));
    }

    public function testSubtract()
    {
        $date = new DateImmutable('2019-01-01');

        $newDate = $date->subtract(1, DatePeriods::DAY);

        $this->assertNotSame($date, $newDate);
        $this->assertNotSame(PropertyAccessor::getPropertyValue($date, 'dateTime'), PropertyAccessor::getPropertyValue($newDate, 'dateTime'));

        $this->assertEquals('2019-01-01', $date->format('Y-m-d'));
        $this->assertEquals('2018-12-31', $newDate->format('Y-m-d'));
    }

    public function testSetDay()
    {
        $date = new DateImmutable('2019-01-01');

        $newDate = $date->setDay(2);

        $this->assertNotSame($date, $newDate);
        $this->assertNotSame(PropertyAccessor::getPropertyValue($date, 'dateTime'), PropertyAccessor::getPropertyValue($newDate, 'dateTime'));

        $this->assertEquals('2019-01-01', $date->format('Y-m-d'));
        $this->assertEquals('2019-01-02', $newDate->format('Y-m-d'));
    }
}
