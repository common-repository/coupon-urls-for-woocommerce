<?php

namespace CouponURLs\App\Creation\Coupons;

use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\Original\Collections\Collection;

class CouponsFactory
{
    /**
     * @var \CouponURLs\App\Creation\Coupons\CouponFactory
     */
    protected $couponFactory;
    public function __construct(CouponFactory $couponFactory)
    {
        $this->couponFactory = $couponFactory;
    }
    
    public function createFromCodes(Collection $couponCodes) : Coupons
    {
        return new Coupons($couponCodes->map(\Closure::fromCallable([$this->couponFactory, 'createFromCodeOrID'])));
    }
}