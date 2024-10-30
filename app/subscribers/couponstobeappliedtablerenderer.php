<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\App\Presentation\Components\CouponsToBeAppliedTableComponent;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;
class CouponsToBeAppliedTableRenderer implements Subscriber
{
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    use DefaultPriority;
    use EmptyCustomArguments;
    public function __construct(CouponsToBeAdded $couponsToBeAdded)
    {
        $this->couponsToBeAdded = $couponsToBeAdded;
    }
    public function validator() : Validator
    {
        return new ValidWhen($this->couponsToBeAdded->coupons()->asCollection()->haveAny());
    }
    public function execute() : void
    {
        (object) ($couponsToBeAppliedTableComponent = new CouponsToBeAppliedTableComponent($this->couponsToBeAdded));
        $couponsToBeAppliedTableComponent->render();
    }
}