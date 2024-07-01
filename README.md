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
use Orangesoft\BackOff\Retry\Retry;

$retry = new Retry(
    maxAttempts: 3,
    backOff: new ExponentialBackOff(
        baseTime: new Microseconds(1_000),
        capTime: new Microseconds(512_000),
        factor: 2.0,
    ),
    exceptionClassifier: new ExceptionClassifier(
        classNames: [
            \RuntimeException::class,
        ],
    ),
);
```

Use the `Orangesoft\BackOff\Retry\Retry::call(callable $callback): mixed` method to wrap the business logic and call it with retry functionality:

```php
/** @var int $result */
$result = $retry->call(static function (): int {
    $random = mt_rand(0, 1);
    
    if (0 === $random % 2) {
        throw new \RuntimeException();
    }
    
    return $random;
});
```

The following back-off strategies are available:

- [Orangesoft\BackOff\CallbackBackOff](./src/CallbackBackOff.php)
- [Orangesoft\BackOff\ConstantBackOff](./src/ConstantBackOff.php)
- [Orangesoft\BackOff\DecorrelatedJitterBackOff](./src/DecorrelatedJitterBackOff.php)
- [Orangesoft\BackOff\ExponentialBackOff](./src/ExponentialBackOff.php)
- [Orangesoft\BackOff\FibonacciBackOff](./src/FibonacciBackOff.php)
- [Orangesoft\BackOff\LinearBackOff](./src/LinearBackOff.php)

## Enable Jitter

Pass the implementation of `Orangesoft\BackOff\Jitter\JitterInterface::class` to the back-off class and jitter will be enabled:

```php
<?php

use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;

$backOff = new ExponentialBackOff(
    baseTime: new Microseconds(1_000),
    capTime: new Microseconds(512_000),
    factor: 2.0,
    jitter: new EqualJitter(),
);

for ($i = 1; $i <= 10; $i++) {
    $backOff->backOff(
        attempt: $i,
    );
}
```

Below you can see the time intervals in microseconds for exponential back-off with a multiplier of `2.0` and equal jitter, where the base time is `1_000` μs and the cap time is `512_000` μs:

```text
+---------+---------------------------+--------------------+
| attempt | exponential back-off (μs) | equal jitter (μs)  |
+---------+---------------------------+--------------------+
|       1 |                     1_000 |         [0, 1_000] |
|       2 |                     2_000 |     [1_000, 2_000] |
|       3 |                     4_000 |     [2_000, 4_000] |
|       4 |                     8_000 |     [4_000, 8_000] |
|       5 |                    16_000 |    [8_000, 16_000] |
|       6 |                    32_000 |   [16_000, 32_000] |
|       7 |                    64_000 |   [32_000, 64_000] |
|       8 |                   128_000 |  [64_000, 128_000] |
|       9 |                   256_000 | [128_000, 256_000] |
|      10 |                   512_000 | [256_000, 512_000] |
+---------+---------------------------+--------------------+
```

The following jitters are available:

- [Orangesoft\BackOff\Jitter\EqualJitter](./src/Jitter/EqualJitter.php)
- [Orangesoft\BackOff\Jitter\FullJitter](./src/Jitter/FullJitter.php)
- [Orangesoft\BackOff\Jitter\ScatteredJitter](./src/Jitter/ScatteredJitter.php)

Read more about Back-Off and Jitter on [AWS Architecture Blog](https://aws.amazon.com/ru/blogs/architecture/exponential-backoff-and-jitter/).
