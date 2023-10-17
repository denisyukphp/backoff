# BackOff

[![Build Status](https://img.shields.io/github/actions/workflow/status/denisyukphp/backoff/ci.yml?branch=main&style=plastic)](https://github.com/denisyukphp/backoff/actions/workflows/ci.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/orangesoft/backoff?style=plastic)](https://packagist.org/packages/orangesoft/backoff)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/orangesoft/backoff?style=plastic&color=8892BF)](https://packagist.org/packages/orangesoft/backoff)
[![Total Downloads](https://img.shields.io/packagist/dt/orangesoft/backoff?style=plastic)](https://packagist.org/packages/orangesoft/backoff)
[![License](https://img.shields.io/packagist/l/orangesoft/backoff?style=plastic&color=428F7E)](https://packagist.org/packages/orangesoft/backoff)

Back-off algorithm implementation.

## Installation

You can install the latest version via [Composer](https://getcomposer.org/):

```text
composer require orangesoft/backoff
```

This package requires PHP 8.1 or later.

## Quick usage

Configure `Orangesoft\BackOff\Retry\Retry::class`, any of back-off classes, and `Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier::class` to retry a business logic when an exception is thrown:

```php
<?php

use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\BackOffRetry;

$backOffRetry = new BackOffRetry(
    maxAttempts: 3,
    baseTime: new Microseconds(1_000),
    capTime: new Microseconds(10_000),
    backOff: new ExponentialBackOff(multiplier: 2.0),
    exceptionClassifier: new ExceptionClassifier(
        classNames: [
            \Exception::class,
        ],
    ),
);
```

Use the `Orangesoft\BackOff\Retry\BackOffRetry::call(callable $callback): mixed` method to wrap the business logic and call it with retry functionality:

```php
/** @var int $result */
$result = $backOffRetry->call(static function (): int {
    $random = mt_rand(5, 10);
    
    if (0 === $random % 2) {
        throw new \RuntimeException();
    }
    
    return $random;
});
```

The following back-off strategies are available:

- [Orangesoft\BackOff\CallbackBackOff](./src/CallbackBackOff.php)
- [Orangesoft\BackOff\DecorrelatedJitterBackOff](./src/DecorrelatedJitterBackOff.php)
- [Orangesoft\BackOff\ExponentialBackOff](./src/ExponentialBackOff.php)
- [Orangesoft\BackOff\FibonacciBackOff](./src/FibonacciBackOff.php)
- [Orangesoft\BackOff\LinearBackOff](./src/LinearBackOff.php)
- [Orangesoft\BackOff\PermanentBackOff](./src/PermanentBackOff.php)

## Enable jitter

Pass the implementation of `Orangesoft\BackOff\Jitter\JitterInterface::class` to the back-off class and jitter will be enabled:

```php
<?php

use Orangesoft\BackOff\LinearBackOff;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;

$equalJitter = new EqualJitter();
$exponentialBackOff = new LinearBackOff($equalJitter);

$exponentialBackOff->backOff(
    attempt: 1,
    baseTime: new Microseconds(1_000),
    capTime: new Microseconds(10_000),
);
```

Below you can see the time intervals in microseconds for linear back-off and equal jitter, where the base time is 1000 μs and the cap time is 10000 μs:

```text
+---------+----------------------+-------------------+
| attempt | linear back-off (μs) | equal jitter (μs) |
+---------+----------------------+-------------------+
|       1 |                1_000 |        [0, 1_000] |
|       2 |                2_000 |    [1_000, 2_000] |
|       3 |                3_000 |    [2_000, 3_000] |
|       4 |                4_000 |    [3_000, 4_000] |
|       5 |                5_000 |    [4_000, 5_000] |
|       6 |                6_000 |    [5_000, 6_000] |
|       7 |                7_000 |    [6_000, 7_000] |
|       8 |                8_000 |    [7_000, 8_000] |
|       9 |                9_000 |    [8_000, 9_000] |
|      10 |               10_000 |   [9_000, 10_000] |
+---------+----------------------+-------------------+
```

The following jitters are available:

- [Orangesoft\BackOff\Jitter\EqualJitter](./src/Jitter/EqualJitter.php)
- [Orangesoft\BackOff\Jitter\FullJitter](./src/Jitter/FullJitter.php)
- [Orangesoft\BackOff\Jitter\ScatteredJitter](./src/Jitter/ScatteredJitter.php)

Read more about Back-Off and Jitter on [AWS Architecture Blog](https://aws.amazon.com/ru/blogs/architecture/exponential-backoff-and-jitter/).
