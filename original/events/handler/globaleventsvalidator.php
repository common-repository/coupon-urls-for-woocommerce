<?php

namespace CouponURLs\Original\Events\Handler;

abstract class GlobalEventsValidator
{
    public abstract function canBeExecuted() : bool;
}