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

### DateTime Comparison
```php
<?php
use Palmtree\Chrono\DateTime;

$dateTime = new DateTime('2019-01-01 12:30:00');

$dateTime->format('d/m/Y H:i'); // returns 01/01/2019 12:30

$anotherDateTime = new DateTime('2019-01-01 12:30:01');

$dateTime->isSame($anotherDateTime); // returns false
$dateTime->isSame($anotherDateTime, 'day'); // returns true
$dateTime->isSame($anotherDateTime, 'hour'); // returns true
$dateTime->isSame($anotherDateTime, 'minute'); // returns true

$dateTime->isBefore($anotherDateTime); // returns true
$dateTime->isAfter($anotherDateTime); // returns false
```

### Min / Max

Helper methods exist to return either the earliest date from a set of dates:

```php
<?php
use Palmtree\Chrono\Date;

$jan = new Date('2019-01-01');
$feb = new Date('2019-02-01');
$march = new Date('2019-03-01');

$minDate = Date::min($jan, $feb, $march);

return $minDate === $jan; // returns true;
```

And the latest date:

```php
<?php
use Palmtree\Chrono\Date;

$jan = new Date('2019-01-01');
$feb = new Date('2019-02-01');
$march = new Date('2019-03-01');

$maxDate = Date::max($jan, $feb, $march);

return $maxDate === $march; // returns true;
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
