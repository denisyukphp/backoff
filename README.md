# Backoff

[![Build Status](https://img.shields.io/travis/com/Orangesoft-Development/backoff/main?style=plastic)](https://travis-ci.com/Orangesoft-Development/backoff)
[![Latest Stable Version](https://img.shields.io/packagist/v/orangesoft/backoff?style=plastic)](https://packagist.org/packages/orangesoft/backoff)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/orangesoft/backoff?style=plastic&color=8892BF)](https://packagist.org/packages/orangesoft/backoff)
[![Total Downloads](https://img.shields.io/packagist/dt/orangesoft/backoff?style=plastic)](https://packagist.org/packages/orangesoft/backoff)
[![License](https://img.shields.io/packagist/l/orangesoft/backoff?style=plastic&color=428F7E)](https://packagist.org/packages/orangesoft/backoff)

Backoff algorithm implementation.

## Installation

You can install the latest version via [Composer](https://getcomposer.org/):

```text
composer require orangesoft/backoff
```

This package requires PHP 7.2 or later.

## Quick usage

Configure base time, cap time and max attempts:

```php
<?php

use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Duration\Seconds;
use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Factory\ExponentialBackoff;
use Orangesoft\Backoff\Exception\LimitedAttemptsException;

$baseTime = new Milliseconds(1000);
$capTime = new Seconds(60);
$maxAttempts = 5;

$backoff = new ExponentialBackoff($baseTime, $capTime, $maxAttempts);

/** @var DurationInterface $backoffTime */
$backoffTime = $backoff->generate($attempt = 4);

// float(16000)
$backoffTime->asMilliseconds();
```

To process cases when max attempts is already exceeded catch [LimitedAttemptsException](https://github.com/Orangesoft-Development/backoff/blob/main/src/Exception/LimitedAttemptsException.php):

```php
try {
    $backoff->generate($attempt = 10);
} catch (LimitedAttemptsException $e) {
    // ...
}
```

The count of the number of attempts starts at zero.

## Documentation

- [Configure Backoff](docs/index.md#configure-backoff)
- [Enable Jitter](docs/index.md#enable-jitter)
- [Use Factory](docs/index.md#use-factory)
- [Sleep with Backoff](docs/index.md#sleep-with-backoff)
- [Retry for exceptions](docs/index.md#retry-for-exceptions)
- [Handle limited attempts](docs/index.md#handle-limited-attempts)

Read more about ExponentialBackoff and Jitter on [AWS Architecture Blog](https://aws.amazon.com/ru/blogs/architecture/exponential-backoff-and-jitter/).
