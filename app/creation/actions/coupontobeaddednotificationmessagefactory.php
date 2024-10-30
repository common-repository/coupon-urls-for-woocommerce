<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Messages\CouponToBeAddedNotificationMessage;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;

class CouponToBeAddedNotificationMessageFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    public function __construct(CouponsToBeAdded $couponsToBeAdded)
    {
        $this->couponsToBeAdded = $couponsToBeAdded;
    }
    
    public function create(Coupon $coupon, MappedObject $options): \CouponURLs\App\Domain\Abilities\Actionable
    {
        return new CouponToBeAddedNotificationMessage(
            $options->message,
            $this->couponsToBeAdded,
            $coupon
        );
    } 
}