# Documentation

- [Configure Backoff](#configure-backoff)
- [Enable Jitter](#enable-jitter)
- [Use Factory](#use-factory)
- [Sleep with Backoff](#sleep-with-backoff)
- [Retry for exceptions](#retry-for-exceptions)
- [Handle limited attempts](#handle-limited-attempts)

## Configure Backoff

Configure base time, cap time and max attempts. The cap time and max attempts are not required. By default the cap time is 60 seconds and max attempts is `INF`.

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

Also you must choose a strategy for generating a backoff time. Available are strategies such as constant, exponential, linear and decorrelation. Then instance Backoff with configured the strategy and a config.

```php
/** @var DurationInterface $backoffTime */
$backoffTime = $backoff->generate($attempt = 4);

// float(16000)
$backoffTime->toMilliseconds();
```

Backoff generates a duration time which is based on the base time and the choices strategy. As a result, you can work with such values of time as a second, millisecond, microsecond and nanosecond.

## Enable Jitter

Enabled Jitter allows to add an noise for the backoff time. This is necessary in order to make the generation of the backoff time unlike each other. Turn on it is very simple:

```php
<?php

use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Jitter\EqualJitter;

$config = (new ConfigBuilder())
    ->setJitter(new EqualJitter())
    ->build()
;
```

You can use [EqualJitter](../src/Jitter/EqualJitter.php) or [FullJitter](../src/Jitter/FullJitter.php). By default Jitter is disabled.

## Use Factory

To easiest way to instance Backoff is use BackoffFactory. This makes configuring and instantiating Backoff easier. Just configure base time, cap time, max attempts and pass them to the factory method:

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

Cap time and max attempts are not required in BackoffFactory. The same can be done by directly instantiating Backoff:

```php
$baseTime = new Milliseconds(1000);

/** @var BackoffInterface $backoff */
$backoff = new ExponentialEqualJitterBackoff($baseTime);
```

The following backoff factories are available:

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

## Sleep with Backoff

The main purpose Backoff is that to pause certain parts of the code for a while. This can be achieved by using Sleeper. Just instance Sleeper with some Backoff instance:

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

The exact same effect can be obtained if immediately instance Sleeper with definitely strategy:

```php
$baseTime = new Milliseconds(1000);

$sleeper = new ExponentialSleeper($baseTime);

// usleep(16000000);
$sleeper->sleep($attempt = 4);
```

Sleeper falls asleep with microsecond precision.

## Retry for exceptions

You can retry to any exceptions and put the backoff time before the next call but before it you must configure Retry where must to set Sleeper:

```php
<?php

use Orangesoft\Retry\RetryBuilder;
use Orangesoft\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\Backoff\Sleeper\ExponentialSleeper;
use Orangesoft\Backoff\Duration\Milliseconds;

$baseTime = new Milliseconds(1000);

$sleeper = new ExponentialSleeper($baseTime);

$exceptionClassifier = new ExceptionClassifier([
    \RuntimeException::class,
]);

$retry = (new RetryBuilder())
    ->setMaxAttempts(5)
    ->setSleeper($sleeper)
    ->setExceptionClassifier($exceptionClassifier)
    ->build()
;
```

By default max attempts is 5, Sleeper is disabled and the ExceptionClassifier catch all exceptions.

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

Retry will try to call the callback with args equal to the number set in max attempts in the config and it will put the backoff time each times for current attempt.

## Handle limited attempts

For Backoff you can set max attempts and when this number is exceeded LimitedAttemptsException will be thrown:

```php
<?php

use Orangesoft\Retry\RetryBuilder;
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

It works exactly the same for Sleeper:

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

For Retry you can set the max attempts to `PHP_INT_MAX` to disable max attempts for the retry tool and enable max attempts for Sleeper:

```php
$retry = (new RetryBuilder())
    ->setMaxAttempts(PHP_INT_MAX)
    ->setSleeper($sleeper)
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

To disable max attempts of the retry tool you need to set the largest number that supports PHP.
