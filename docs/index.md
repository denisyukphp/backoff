# Documentation

- [Configure backoff](#configure-backoff)
- [Enable jitter](#enable-jitter)
- [Use factory](#use-factory)
- [Sleep with backoff](#sleep-with-backoff)
- [Retry for exceptions](#retry-for-exceptions)
- [Handle limited attempts](#handle-limited-attempts)

## Configure backoff

Configure base time, cap time and max attempts. The base time is the time for calculating a Backoff algorithm, the cap time is the limitation of calculations for base time, max attempts is the limit of call a backoff time generate. Cap time and max attempts are not required. By default cap time is 60 seconds and max attempts is `INF`.

```php
<?php

use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Duration\Seconds;
use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Strategy\ExponentialStrategy;
use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Backoff;

$baseTime = new Milliseconds(1000);
$capTime = new Seconds(60);
$maxAttempts = 5;

$strategy = new ExponentialStrategy($baseTime);

$config = (new ConfigBuilder())
    ->setCapTime($capTime)
    ->setMaxAttempts($maxAttempts)
    ->build()
;

$backoff = new Backoff($strategy, $config);
```

Also you must choose a strategy for generating the backoff time. Available are strategies such as constant, exponential, linear and decorrelation. Then instance the Backoff with configured a strategy and a config.

```php
/** @var DurationInterface $backoffTime */
$backoffTime = $backoff->generate($attempt = 4);

// float(16000)
$backoffTime->toMilliseconds();
```

Backoff generates duration time which based on base time and choices strategy. As a result, you can work with such values of time as a second, millisecond, microsecond and nanosecond.

## Enable jitter

Enabled jitter allows to add an noise for a backoff time. This is necessary in order to make the generation of the backoff time unlike each other.

```php
<?php

use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Jitter\EqualJitter;

$config = (new ConfigBuilder())
    ->setJitter(new EqualJitter())
    ->build()
;
```

You can use [EqualJitter](https://github.com/Orangesoft-Development/backoff/blob/main/src/Jitter/EqualJitter.php) or [FullJitter](https://github.com/Orangesoft-Development/backoff/blob/main/src/Jitter/FullJitter.php). By default jitter is disabled.

## Use factory

To easiest way to instance a Backoff is use a backoff factory. This makes configuring and instantiating the Backoff easier. Just configure base time, cap time, max attempts and pass them to the factory method:

```php
<?php

use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Duration\Seconds;
use Orangesoft\Backoff\Factory\BackoffFactory;
use Orangesoft\Backoff\Factory\ExponentialEqualJitterBackoff;
use Orangesoft\Backoff\BackoffInterface;

$baseTime = new Milliseconds(1000);
$capTime = new Seconds(60);
$maxAttempts = 5;

$factory = new BackoffFactory();

/** @var ExponentialEqualJitterBackoff $backoff */
$backoff = $factory->getExponentialEqualJitterBackoff($baseTime, $capTime, $maxAttempts);
```

Cap time and max attempts are not required in the backoff factory. The same can be done by directly instantiating the Backoff:

```php
$baseTime = new Milliseconds(1000);

/** @var BackoffInterface $backoff */
$backoff = new ExponentialEqualJitterBackoff($baseTime);
```

The following the backoff factories are available:

- [ConstantBackoff](../src/Factory/ConstantBackoff.php)
- [ConstantFullJitterBackoff](../src/Factory/ConstantFullJitterBackoff.php)
- [ConstantEqualJitterBackoff](../src/Factory/ConstantEqualJitterBackoff.php)
- [DecorrelationJitterBackoff](../src/Factory/DecorrelationJitterBackoff.php)
- [ExponentialBackoff](../src/Factory/ExponentialBackoff.php)
- [ExponentialFullJitterBackoff](../src/Factory/ExponentialFullJitterBackoff.php)
- [ExponentialEqualJitterBackoff](../src/Factory/ExponentialEqualJitterBackoff.php)
- [LinearBackoff](../src/Factory/LinearBackoff.php)
- [LinearFullJitterBackoff](../src/Factory/LinearFullJitterBackoff.php)
- [LinearEqualJitterBackoff](../src/Factory/LinearEqualJitterBackoff.php)

## Sleep with backoff

The main purpose of Backoff is that to pause certain parts of the code for a while. This can be achieved by using a Sleeper. Just instance the Sleeper with some Backoff instance:

```php
<?php

use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ExponentialBackoff;
use Orangesoft\Backoff\Sleeper\ExponentialSleeper;
use Orangesoft\Backoff\Sleeper\Sleeper;

$baseTime = new Milliseconds(1000);
$backoff = new ExponentialBackoff($baseTime);
$sleeper = new Sleeper($backoff);

// usleep(16000000);
$sleeper->sleep($attempt = 4);
```

The exact same effect can be obtained if immediately instance the Sleeper with definitely strategy:

```php
$baseTime = new Milliseconds(1000);

$sleeper = new ExponentialSleeper($baseTime);

// usleep(16000000);
$sleeper->sleep($attempt = 4);
```

The Sleeper falls asleep with microsecond precision.

## Retry for exceptions

To retry exceptions with backoff you must install additional package via Composer:

```text
composer require orangesoft/retry
```

Now you can retry to any exceptions and put a backoff time before the next call but before it you must configure the retry tool where must to set max attempts, a sleeper and a exception classifier:

```php
<?php

use Orangesoft\Retry\Retry;
use Orangesoft\Retry\Sleeper\BackoffSleeper;
use Orangesoft\Backoff\Factory\ExponentialBackoff;
use Orangesoft\Backoff\Duration\Milliseconds;

$baseTime = new Milliseconds(1000);
$backoff = new ExponentialBackoff($baseTime);
$backoffSleeper = new BackoffSleeper($backoff);

$exceptionClassifier = new ExceptionClassifier([
    \RuntimeException::class,
]);

$retry = (new RetryBuilder())
    ->setMaxAttempts(5)
    ->setSleeper($backoffSleeper)
    ->setExceptionClassifier($exceptionClassifier)
    ->build()
;
```

The retry tool is very similar to `call_user_func_array()` in that its method `call()` also accepts a callback and arguments.

```php
/**
 * @param int $min
 * @param int $max
 * 
 * @return int
 * 
 * @throws \RuntimeException
 */
$callback = function (int $min, int $max): int {
    $random = mt_rand($min, $max);
    
    if (0 === $random % 2) {
        throw new \RuntimeException();
    }
    
    return $random;
};

$args = [5, 10];
```

Now just call the `call()` method:

```php
$retry->call($callback, $args);
```

Retry will try to call the callable with args equal to the number set in max attempts in the config and it will put a backoff time each times for current attempt.

## Handle limited attempts

For a Backoff you can set max attempts and when this number is exceeded, a LimitedAttemptsException will be thrown:

```php
<?php

use Orangesoft\Retry\RetryBuilder;
use Orangesoft\Retry\Sleeper\BackoffSleeper;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Duration\Seconds;
use Orangesoft\Backoff\Factory\ExponentialBackoff;
use Orangesoft\Backoff\Sleeper\Sleeper;
use Orangesoft\Backoff\Exception\LimitedAttemptsException;

$baseTime = new Milliseconds(1000);
$capTime = new Seconds(60);
$maxAttempts = 5;

$backoff = new ExponentialBackoff($baseTime, $capTime, $maxAttempts);

try {
    $backoff->generate($attempt = 10);
} catch (LimitedAttemptsException $e) {
    // ...
}
```

It works exactly the same for a Sleeper:

```php
$sleeper = new Sleeper($backoff);

try {
    for ($i = 0; $i < 10; $i++) {
        $sleeper->sleep($i);
    }
} catch (LimitedAttemptsException $e) {
    // ...
}
```

For a Retry you can set the max attempts to `PHP_INT_MAX` to disable max attempts for a retry tool and turn on count attempts of a BackoffSleeper:

```php
$backoffSleeper = new BackoffSleeper($backoff);

$retry = (new RetryBuilder())
    ->setMaxAttempts(PHP_INT_MAX)
    ->setSleeper($backoffSleeper)
    ->build()
;

try {
    $retry->call(function () {
        throw new \RuntimeException();
    });
} catch (LimitedAttemptsException $e) {
    // ...
}
```

By default max attempts of the retry tool is 5. To disable it, you need to set the largest number that supports PHP.
