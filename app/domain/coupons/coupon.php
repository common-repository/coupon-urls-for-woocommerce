<?php

namespace CouponURLs\App\Domain\Coupons;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Domain\Entity;
use WC_Coupon;
use WC_Discounts;

use function CouponURLs\Original\Utilities\Text\i;

Class Coupon extends Entity
{
    /**
     * @var \WC_Coupon
     */
    protected $classic;
    /**
     * @var \WC_Discounts|null
     */
    protected $discounts;
    public function __construct(WC_Coupon $classic, ?WC_Discounts $discounts = null)
    {
        $this->classic = $classic;
        $this->discounts = $discounts;
    }
 
    // not empty '', is valid and does not exist in cart    
    public function canBeApplied() : bool
    {
        #might seem weird but is_coupon_valid() returns a WP_error on false
        return $this->discounts->is_coupon_valid($this->classic) === true ?: false;
    }

    public function code() : StringManager
    {
        return i($this->classic->get_code('edit'));
    }

    public function id() : int
    {
        return $this->classic->get_id();
    }
}