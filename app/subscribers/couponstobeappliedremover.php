<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\WillAlwaysExecute;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use function CouponURLs\Original\Utilities\Collection\_;
/**
 * Removes the coupons to be applied that have already been applied and 
 * are now in the cart
 */
class CouponsToBeAppliedRemover implements Subscriber
{
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    use DefaultPriority;
    use WillAlwaysExecute;
    public function __construct(CouponsToBeAdded $couponsToBeAdded, Cart $cart)
    {
        $this->couponsToBeAdded = $couponsToBeAdded;
        $this->cart = $cart;
    }
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(neblabs_collection(['allCouponsToBeAdded' => $this->couponsToBeAdded->coupons()]));
    }
    public function execute(Coupons $allCouponsToBeAdded) : void
    {
        (object) ($couponsToBeRemoved = $allCouponsToBeAdded->asCollection()->filter(\Closure::fromCallable([$this->cart, 'has'])));
        $couponsToBeRemoved->forEvery(\Closure::fromCallable([$this->couponsToBeAdded, 'remove']));
    }
}