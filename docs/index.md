# Documentation

- [Configure Generator](#configure-generator)
- [Enable Jitter](#enable-jitter)
- [Sleep by Duration](#sleep-by-duration)
- [Handle max attempts](#handle-max-attempts)
- [Use BackOff](#use-backoff)
- [Create BackOff facades](#create-backoff-facades)
- [Retry exceptions](#retry-exceptions)

## Configure Generator

Configure max attempts, base time, cap time and strategy. All options are not required. By default max attempts is `INF`, base time is 1 second, cap time is 1 minute, strategy is exponential with multiplier is 2.

```php
<?php

use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;

$generator = GeneratorBuilder::create()
    ->setMaxAttempts(INF)
    ->setBaseTime(new Milliseconds(1000))
    ->setCapTime(new Milliseconds(60 * 1000))
    ->setStrategy(new ExponentialStrategy(2))
    ->build()
;
```

Generator returns a duration time to sleep:

```php
$attempt = 3;

/** @var DurationInterface $duration */
$duration = $generator->generate($attempt);

// float(8000)
$duration->asMilliseconds();
```

As a result, you can work with such values of time as seconds, milliseconds, microseconds and nanoseconds.

## Enable Jitter

Enabled Jitter allows to add an noise for the back-off time. Turn on it is very simple:

```php
<?php

use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Jitter\EqualJitter;

$generator = GeneratorBuilder::create()
    ->setJitter(new EqualJitter())
    ->build()
;
```

You can use [EqualJitter](../src/Jitter/EqualJitter.php) or [FullJitter](../src/Jitter/FullJitter.php). By default Jitter is disabled.

## Sleep by Duration

Pass the duration time to Sleeper as below:

```php
<?php

use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;

$sleeper = new Sleeper();

$generator = GeneratorBuilder::create()
    ->setMaxAttempts(INF)
    ->setBaseTime(new Milliseconds(1000))
    ->setCapTime(new Milliseconds(60 * 1000))
    ->setStrategy(new ExponentialStrategy(2))
    ->build()
;

$attempt = 3;

/** @var DurationInterface $duration */
$duration = $generator->generate($attempt);

// usleep(8000000)
$sleeper->sleep($duration);
```

Configure base time and cap time with microseconds precision because Sleeper converts the duration to integer before sleep and truncates numbers after point. For example 1 nanosecond is 0.001 microseconds so it would converted to 0:

```text
+--------------+-------------+
| Nanoseconds  |           1 |
| Microseconds |       0.001 |
| Milliseconds |    0.000001 |
| Seconds      | 0.000000001 |
+--------------+-------------+
```

Use nanoseconds for high-precision calculations.

## Handle max attempts

Set max attempts to zero or more and catch [MaxAttemptsException](../src/Generator/Exception/MaxAttemptsException.php) to take an action when max attempts has been over:

```php
<?php

use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Generator\Exception\MaxAttemptsException;

$generator = GeneratorBuilder::create()
    ->setMaxAttempts(3)
    ->build()
;

$attempt = 10;

try {
    $generator->generate($attempt);
} catch (MaxAttemptsException $e) {
    // ...
}
```

Generator is independent of the generation sequence of the duration time.

## Use BackOff

BackOff accepts Generator and Sleeper dependencies:

```php
<?php

use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\BackOff;

$generator = GeneratorBuilder::create()
    ->setMaxAttempts(3)
    ->build()
;

$sleeper = new Sleeper();

$backOff = new BackOff($generator, $sleeper);
```

The main purpose of BackOff is to fall asleep for a while time or throw an exception if max attempts has been reached:

```php
$backOff->backOff(10, new \RuntimeException());
```

Use an exception that might be required to retry in your business logic.

## Create BackOff facades

Facades allow to quickly instance BackOff without using Generator. By default for [ExponentialBackOff](../src/Facade/ExponentialBackOff.php) max attempts is 5, base time is 1 second, cap time is 1 minute, multiplier is 2, Jitter is disabled and Sleeper is default:

```php
<?php

use Orangesoft\BackOff\Facade\ExponentialBackOff;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;

$maxAttempts = 3;
$baseTimeMs = 1000;
$capTimeMs = 60 * 1000;
$multiplier = 2;
$jitter = new DummyJitter();
$sleeper = new Sleeper();

$backOff = new ExponentialBackOff($maxAttempts, $baseTimeMs, $capTimeMs, $multiplier, $jitter, $sleeper);
```

The following facades are available:

- [ConstantBackOff](../src/Facade/ConstantBackOff.php)
- [LinearBackOff](../src/Facade/LinearBackOff.php)
- [ExponentialBackOff](../src/Facade/ExponentialBackOff.php)
- [DecorrelationJitterBackOff](../src/Facade/DecorrelationJitterBackOff.php)

## Retry exceptions

Configure BackOff and ExceptionClassifier to retry your business logic when an exception will be thrown:

```php
<?php

use Orangesoft\BackOff\Facade\ExponentialBackOff;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\Retry;

$maxAttempts = 3;
$baseTimeMs = 1000;

$backOff = new ExponentialBackOff($maxAttempts, $baseTimeMs);

$exceptionClassifier = new ExceptionClassifier([
    \RuntimeException::class,
]);

$retry = new Retry($backOff, $exceptionClassifier);
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
