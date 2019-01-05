<?php

namespace Palmtree\Chrono\Tests\Util;

class PropertyAccessor
{
    public static function getPropertyValue($object, string $property)
    {
        $reflectionObject = new \ReflectionObject($object);

        $property = $reflectionObject->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
