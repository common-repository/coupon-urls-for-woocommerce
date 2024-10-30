<?php

namespace CouponURLs\Original\Tasks;

use CouponURLs\Original\Collections\Collection;
use Exception;
abstract class Task
{
    public abstract function run(Collection $taskData);
}