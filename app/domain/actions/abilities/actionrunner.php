<?php

namespace CouponURLs\App\Domain\Actions\Abilities;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\Original\Collections\Collection;

interface ActionRunner
{
    /**
     * @param \CouponURLs\App\Domain\Abilities\Actionable|\CouponURLs\App\Domain\Abilities\RestrictableAction $action
     */
    public function canRun($action) : bool;
    /**
     * @param \CouponURLs\App\Domain\Abilities\Actionable|\CouponURLs\App\Domain\Abilities\RestrictableAction $action
     */
    public function run($action) : void;
}