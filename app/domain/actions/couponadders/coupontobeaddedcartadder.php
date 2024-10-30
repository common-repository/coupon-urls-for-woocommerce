<?php

namespace CouponURLs\App\Domain\Actions\CouponAdders;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use WC_Cart;

class CouponToBeAddedCartAdder implements Actionable, RestrictableAction
{
    /**
     * @var \CouponURLs\App\Domain\Coupons\Coupon
     */
    protected $coupon;
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    public function __construct(Coupon $coupon, CouponsToBeAdded $couponsToBeAdded, Cart $cart)
    {
        $this->coupon = $coupon;
        $this->couponsToBeAdded = $couponsToBeAdded;
        $this->cart = $cart;
    }

    public function canPerform(): Validator
    {
        return new Validators([
            new ValidWhen(!$this->cart->has($this->coupon)),
            new ValidWhen(!$this->couponsToBeAdded->has($this->coupon)),
        ]);    
    } 

    public function perform(): void
    {
        $this->couponsToBeAdded->add($this->coupon);
    } 
}