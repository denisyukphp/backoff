# BackOff

[![Build Status](https://img.shields.io/travis/com/Orangesoft-Development/backoff/main?style=plastic)](https://travis-ci.com/Orangesoft-Development/backoff)
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

This package requires PHP 7.2 or later.

## Quick usage

Configure BackOff and ExceptionClassifier to retry your business logic when an exception will be thrown:

```php
<?php

use Orangesoft\BackOff\Facade\ExponentialBackOff;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\Retry;

$maxAttempts = 5;
$baseTimeMs = 1000;

$backOff = new ExponentialBackOff($maxAttempts, $baseTimeMs);

$classifier = new ExceptionClassifier([
    \RuntimeException::class,
]);

$retry = new Retry($backOff, $classifier);
```

Put the business logic in a callback function and call it:

```php
$retry->call(function (): int {
    $random = mt_rand(5, 10);
    
    if (0 === $random % 2) {
        throw new \RuntimeException();
    }
    
    return $random;
});
```

After the exception is thrown call will be retried with a back-off time until max attempts has been reached.

## Documentation

- [Configure Generator](docs/index.md#configure-generator)
- [Enable Jitter](docs/index.md#enable-jitter)
- [Sleep by Duration](docs/index.md#sleep-by-duration)
- [Handle max attempts](docs/index.md#handle-max-attempts)
- [Use BackOff](docs/index.md#use-backoff)
- [Create BackOff facades](docs/index.md#create-backoff-facades)
- [Retry exceptions](docs/index.md#retry-exceptions)

Read more about Back-off and Jitter on [AWS Architecture Blog](https://aws.amazon.com/ru/blogs/architecture/exponential-backoff-and-jitter/).
