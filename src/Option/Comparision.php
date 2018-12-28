<?php

namespace Palmtree\Chrono\Option;

abstract class Comparision
{
    public const EQUAL_TO                 = '==';
    public const LESS_THAN                = '<';
    public const LESS_THAN_OR_EQUAL_TO    = '<=';
    public const GREATER_THAN             = '>';
    public const GREATER_THAN_OR_EQUAL_TO = '>=';

    public static function toArray(): array
    {
        return [
            self::EQUAL_TO,
            self::LESS_THAN,
            self::LESS_THAN_OR_EQUAL_TO,
            self::GREATER_THAN,
            self::GREATER_THAN_OR_EQUAL_TO,
        ];
    }
}
