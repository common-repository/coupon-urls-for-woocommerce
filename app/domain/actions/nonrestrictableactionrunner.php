<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Actions\Abilities\ActionRunner;

class NonRestrictableActionRunner implements ActionRunner
{
    /**
     * @param \CouponURLs\App\Domain\Abilities\Actionable|\CouponURLs\App\Domain\Abilities\RestrictableAction $action
     */
    public function canRun($action): bool
    {
        return !$action instanceof RestrictableAction;
    } 

    /**
     * @param \CouponURLs\App\Domain\Abilities\Actionable|\CouponURLs\App\Domain\Abilities\RestrictableAction $action
     */
    public function run($action): void
    {
        $action->perform();
    } 
}