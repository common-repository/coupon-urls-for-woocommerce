<?php

namespace CouponURLs\App\Domain\Actions;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

class OverloadableActionsDecorator implements Actionable, RestrictableAction
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $restrictableActions;
    public function __construct(Collection /*<Actionable&RestrictableAction>*/ $restrictableActions)
    {
        $this->restrictableActions = $restrictableActions;
    }
    
    public function canPerform(): Validator
    {
        return new ValidWhen(
            (boolean) $this->pickTheValidAction()
        );
    } 

    public function perform(): void
    {
        $this->pickTheValidAction()->perform();
    } 

    public function pickTheValidAction() : ?Actionable
    {
        return $this->restrictableActions->find(
            function (RestrictableAction $action) {
                return $action->canPerform()->isValid();
            }
        );
    }
}