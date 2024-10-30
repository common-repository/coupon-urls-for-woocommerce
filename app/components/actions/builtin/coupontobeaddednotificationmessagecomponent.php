<?php

namespace CouponURLs\App\Components\Actions\Builtin;

use CouponURLs\App\Components\Abilities\Descriptables;
use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Mapper\Types;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\__;
class CouponToBeAddedNotificationMessageComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier() : string
    {
        return 'CouponToBeAddedNotificationMessage';
    }
    public function name()
    {
        return \__("Add Custom Message When Coupon hasn't been added yet", 'coupon-urls-for-woocommerce');
    }
    public function descriptions() : Collection
    {
        return neblabs_collection([\__("This message will be shown when the coupon wasn't added to the cart because it didn't meet the cart requirements", 'coupon-urls-for-woocommerce'), \__("You can use this action to tell the user that they need to add a product or they need a minimum spend.", 'coupon-urls-for-woocommerce')]);
    }
    public function options() : Collection
    {
        return neblabs_collection(['message' => TYPES::STRING()->withDefault(\__('You have a special offer available! It will be applied when your cart meets the requirements.', 'coupon-urls-for-woocommerce'))->meta(['field' => ['width' => 'full']])]);
    }
}