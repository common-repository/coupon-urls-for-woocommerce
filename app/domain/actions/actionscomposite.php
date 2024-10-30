<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
#Composite
class ActionsComposite implements Actionable
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $actions;
    /**
     * @var \CouponURLs\App\Domain\Actions\ActionsRunnerComposite
     */
    protected $actionsRunner;
    public function __construct(Collection $actions, ActionsRunnerComposite $actionsRunner)
    {
        $this->actions = $actions;
        $this->actionsRunner = $actionsRunner;
    }
    public function add(Actionable $action) : void
    {
        $this->actions->push($action);
    }
    public function perform() : void
    {
        $this->performExcept(neblabs_collection([]));
    }
    public function performExcept(Collection $actionTypes) : void
    {
        $this->actions->forEvery(\Closure::fromCallable([$this->actionsRunner, 'run']));
    }
}