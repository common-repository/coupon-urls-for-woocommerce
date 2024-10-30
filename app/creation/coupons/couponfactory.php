<?php

namespace CouponURLs\App\Creation\Coupons;

use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Characters\StringManager;
use WC_Coupon;
use WC_Discounts;

class CouponFactory
{
    /**
     * @var \WC_Discounts
     */
    protected $discounts;
    public function __construct(WC_Discounts $discounts)
    {
        $this->discounts = $discounts;
    }
    
    /**
     * @param string|\CouponURLs\Original\Characters\StringManager|int $codeOrId
     */
    public function createFromCodeOrID($codeOrId) : Coupon
    {
        return new Coupon(
            new WC_Coupon($codeOrId), 
            $this->discounts
        );
    }
}