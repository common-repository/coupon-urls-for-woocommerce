<?php

namespace CouponURLs\Original\Events;

use CouponURLs\Original\Abilities\DuckInterface;
use CouponURLs\Original\Abilities\Methods;
interface Subscriber
{
    public function priority() : int;
    /**
     * THEY ALL NEED BE PUBLIC!
     */
    /* public function createEventArguments([...]) : EventArguments; */
    /* public function validator([...]) : Validator; */
    /* public function execute([...]) : void */
}