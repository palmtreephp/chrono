# :palm_tree: Palmtree Chrono

[![License](http://img.shields.io/packagist/l/palmtree/chrono.svg)](LICENSE)
[![Build Status](https://scrutinizer-ci.com/g/palmtreephp/chrono/badges/build.png)](https://scrutinizer-ci.com/g/palmtreephp/chrono/build-status/master)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/palmtreephp/chrono.svg)](https://scrutinizer-ci.com/g/palmtreephp/chrono/)
[![Code Coverage](https://scrutinizer-ci.com/g/palmtreephp/chrono/badges/coverage.png)](https://scrutinizer-ci.com/g/palmtreephp/chrono/)

## Requirements
* PHP >= 7.1

## Installation

Use composer to add the package to your dependencies:
```bash
composer require palmtree/chrono
```

## Usage

### Date Comparison
```php
<?php
use Palmtree\Chrono\Date;

$date = new Date('2019-01-01');

$date->format('d/m/Y');

$anotherDate = new Date('2019-02-01');

$date->isSame($anotherDate, 'year'); // returns true
$date->isSame($anotherDate, 'month'); // returns true
$date->isSame($anotherDate, 'day'); // returns false

$date->isBefore($anotherDate); // returns true
$date->isAfter($anotherDate); // returns false

// returns true if the date object represents the current date
$date->isToday();
```

### Date Manipulation
```php
<?php
use Palmtree\Chrono\Date;

$date = new Date('2019-01-01');

$date->add(10, 'day');

$date->format('Y-m-d'); // returns '2019-01-11'

$date->subtract(1, 'month');

$date->format('Y-m-d'); // returns '2018-12-11'
```

### Time Comparison
```php
<?php
use Palmtree\Chrono\Time;

$time = new Time('13:00:03');

$time->format('H:i');

$anotherTime = new Time('13:02:01');

$time->isSame($anotherTime, 'hour'); // returns true
$time->isSame($anotherTime, 'minute'); // returns false

$time->isBefore($anotherTime); // returns true
$time->isAfter($anotherTime); // returns false
```

### Time Manipulation
```php
<?php
use Palmtree\Chrono\Time;

$time = new Time('13:00:00');

$time
    ->add(1, 'hour')
    ->add(30, 'minute')
    ->add(15, 'second');

$time->format('H:i:s'); // returns '14:30:15'

$time->subtract(15, 'second');

$time->format('H:i:s'); // returns '14:30:00'
```

### Min / Max

Helper methods exist to return the minimum date from a set of dates:

```php
<?php
use Palmtree\Chrono\Date;

$date = new Date('2019-01-01');
$anotherDate = new Date('2019-02-01');

$minDate = Date::min($date, $anotherDate);

return $minDate === $date; // returns true;
```

And the maximum date:

```php
<?php
use Palmtree\Chrono\Date;

$date = new Date('2019-01-01');
$anotherDate = new Date('2019-02-01');

$maxDate = Date::max($date, $anotherDate);

return $maxDate === $anotherDate; // returns true;
```

Use the  [`...` (splat)](http://php.net/manual/en/migration56.new-features.php#migration56.new-features.splat) operator to pass an array of dates to the min or max methods:

```php
<?php
use Palmtree\Chrono\Date;

$dates = [new Date('2019-01-01'), new Date('2019-02-01')];

$minDate = Date::min(...$dates);

return $minDate === $dates[0]; // returns true;
```

## Prior Art

Inspired by the [momentjs](https://momentjs.com) JavaScript library.

## License

Released under the [MIT license](LICENSE)
