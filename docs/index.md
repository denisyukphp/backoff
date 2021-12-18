# Documentation

- [Configure Generator](#configure-generator)
- [Enable Jitter](#enable-jitter)
- [Duration sleep](#duration-sleep)
- [Use BackOff](#use-backoff)
- [Retry exceptions](#retry-exceptions)

## Configure Generator

Configure base time, cap time, strategy and jitter. All options are required:

```php
<?php

use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use Orangesoft\BackOff\Jitter\NullJitter;

$generator = new Generator(
    baseTime: new Milliseconds(1_000),
    capTime: new Milliseconds(60_000),
    strategy: new ExponentialStrategy(multiplier: 2),
    jitter: new NullJitter(),
);
```

Generator returns a duration time to sleep:

```php
/** @var DurationInterface $duration */
$duration = $generator->generate(attempt: 3);;

// float(8000)
$duration->asMilliseconds();
```

As a result, you can work with such values of time as seconds, milliseconds, microseconds and nanoseconds.

## Enable Jitter

Enabled Jitter allows to add a noise for the back-off time. Turn on it is very simple:

```php
<?php

use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use Orangesoft\BackOff\Jitter\EqualJitter;

$generator = new Generator(
    baseTime: new Milliseconds(1_000),
    capTime: new Milliseconds(60_000),
    strategy: new ExponentialStrategy(multiplier: 2),
    jitter: new EqualJitter(),
);
```

You can use [EqualJitter](../src/Jitter/EqualJitter.php) or [FullJitter](../src/Jitter/FullJitter.php).

## Duration sleep

Pass the duration time to Sleeper as below:

```php
<?php

use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;

$generator = new Generator(
    baseTime: new Milliseconds(1_000),
    capTime: new Milliseconds(60_000),
    strategy: new ExponentialStrategy(multiplier: 2),
    jitter: new NullJitter(),
);

$sleeper = new Sleeper();

/** @var DurationInterface $duration */
$duration = $generator->generate(attempt: 3);

// usleep(8000000)
$sleeper->sleep($duration);
```

Configure base time and cap time with microseconds precision because Sleeper converts the duration to integer before sleep and truncates numbers after point. For example 1 nanosecond is 0.001 microseconds, so it would to converted to 0:

```text
+--------------+-------------+
| Nanoseconds  |           1 |
| Microseconds |       0.001 |
| Milliseconds |    0.000001 |
| Seconds      | 0.000000001 |
+--------------+-------------+
```

Use nanoseconds for high-precision calculations.

## Use BackOff

BackOff accepts Generator and Sleeper dependencies:

```php
<?php

use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\BackOff;

$generator = new Generator(
    baseTime: new Milliseconds(1_000),
    capTime: new Milliseconds(60_000),
    strategy: new ExponentialStrategy(multiplier: 2),
    jitter: new NullJitter(),
);

$backOff = new BackOff(
    maxAttempts: 3,
    generator: $generator,
    sleeper: new Sleeper(),
);
```

The main purpose of BackOff is to fall asleep for a while time or throw an exception if max attempts has been reached:

```php
$backOff->backOff(4, new \RuntimeException());
```

Use back-off decorators to quick instance. For example [ExponentialBackOff](../src/ExponentialBackOff.php) max attempts is 3, base time is 1 second, cap time is 1 minute, multiplier is 2, Jitter is disabled and Sleeper is default:

```php
<?php

use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;

$backOff = new ExponentialBackOff(
    maxAttempts: 3,
    baseTime: new Milliseconds(1_000),
    capTime: new Milliseconds(60_000),
    multiplier: 2,
    jitter: new NullJitter(),
    sleeper: new Sleeper(),
);
```

The following back-off decorators are available:

- [ConstantBackOff](../src/ConstantBackOff.php)
- [LinearBackOff](../src/LinearBackOff.php)
- [ExponentialBackOff](../src/ExponentialBackOff.php)
- [DecorrelatedBackOff](../src/DecorrelatedBackOff.php)
- [ImmediatelyThrowableBackOff](../src/ImmediatelyThrowableBackOff.php)

## Retry exceptions

Configure BackOff and ExceptionClassifier to retry your business logic when an exception will be thrown:

```php
<?php

use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\Retry;

$backOff = new ExponentialBackOff(
    maxAttempts: 3,
    baseTime: new Milliseconds(1_000),
);

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
