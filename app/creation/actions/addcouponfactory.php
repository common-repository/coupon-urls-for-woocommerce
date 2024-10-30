<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\CouponAdders\AddCoupon;
use CouponURLs\App\Domain\Actions\CouponAdders\CouponCartAdder;
use CouponURLs\App\Domain\Actions\CouponAdders\CouponToBeAddedCartAdder;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;
use function CouponURLs\Original\Utilities\Collection\_;
class AddCouponFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    public function __construct(Cart $cart, CouponsToBeAdded $couponsToBeAdded)
    {
        $this->cart = $cart;
        $this->couponsToBeAdded = $couponsToBeAdded;
    }
    public function create(Coupon $coupon, MappedObject $options) : \CouponURLs\App\Domain\Abilities\Actionable
    {
        return new AddCoupon(neblabs_collection([new CouponCartAdder($coupon, $this->cart), new CouponToBeAddedCartAdder($coupon, $this->couponsToBeAdded, $this->cart)]));
    }
}