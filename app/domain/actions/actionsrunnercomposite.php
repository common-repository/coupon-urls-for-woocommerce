<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Actions\Abilities\ActionRunner;
use CouponURLs\Original\Collections\Collection;
class ActionsRunnerComposite implements ActionRunner
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $actionRunners;
    public function __construct(Collection $actionRunners)
    {
        $this->actionRunners = $actionRunners;
    }
    /**
     * @param \CouponURLs\App\Domain\Abilities\Actionable|\CouponURLs\App\Domain\Abilities\RestrictableAction $action
     */
    public function canRun($action) : bool
    {
        return $this->actionRunners->haveAny();
    }
    /**
     * @param \CouponURLs\App\Domain\Abilities\Actionable|\CouponURLs\App\Domain\Abilities\RestrictableAction $action
     */
    public function run($action) : void
    {
        /** @var ActionRunner */
        (object) ($runner = $this->actionRunners->findTheOneThat(['canRun' => $action]));
        $runner->run($action);
    }
}