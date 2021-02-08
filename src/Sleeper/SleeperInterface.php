<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Retry\Sleeper\SleeperInterface as RetrySleeperInterface;

interface SleeperInterface extends BackoffSleeperInterface, RetrySleeperInterface
{
}
