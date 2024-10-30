<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\WillAlwaysExecute;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use function CouponURLs\Original\Utilities\Collection\_;
/**
 * Listens to cart changes and tries to apply those coupons
 */
class ScheduledCouponsApplier implements Subscriber
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
        return new EventArguments(neblabs_collection(['allCouponsThatMightBeAdded' => $this->couponsToBeAdded->coupons()]));
    }
    public function execute(Coupons $allCouponsThatMightBeAdded) : void
    {
        $allCouponsThatMightBeAdded->applyValidTo($this->cart);
    }
}