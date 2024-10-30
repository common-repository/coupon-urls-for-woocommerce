<?php

namespace CouponURLs\App\Components\Actions\Builtin;

use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\__;
class AddCouponComponent implements Identifiable, Nameable, HasInlineOptions
{
    public function identifier() : string
    {
        return 'AddCoupon';
    }
    public function name()
    {
        return \__('Add Coupon', 'coupon-urls-for-woocommerce');
    }
    public function options() : Collection
    {
        return neblabs_collection([]);
    }
}