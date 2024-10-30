<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Messages\CouponAddedToCartExtraNotificationMessage;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;

class CouponAddedToCartExtraNotificationMessageFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    
    public function create(Coupon $coupon, MappedObject $options): \CouponURLs\App\Domain\Abilities\Actionable
    {
        return new CouponAddedToCartExtraNotificationMessage(
            $options->message,
            $this->cart,
            $coupon
        );
    } 
}