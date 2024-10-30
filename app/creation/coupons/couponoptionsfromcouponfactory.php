<?php

namespace CouponURLs\App\Creation\Coupons;

use CouponURLs\App\Components\Options\CouponOptionsComponent;
use CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Environment\Env;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;
class CouponOptionsFromCouponFactory implements CreatableFromCouponUrl
{
    /**
     * @var \CouponURLs\App\Components\Options\CouponOptionsComponent
     */
    protected $couponOptionsComponent;
    /**
     * @var \CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory
     */
    protected $couponOptionsFromTemplateFactory;
    public function __construct(CouponOptionsComponent $couponOptionsComponent, OptionsFromTemplateAndOptionableFactory $couponOptionsFromTemplateFactory)
    {
        $this->couponOptionsComponent = $couponOptionsComponent;
        $this->couponOptionsFromTemplateFactory = $couponOptionsFromTemplateFactory;
    }
    public function createFromCoupon(Coupon $coupon) : object
    {
        (object) ($couponUrlData = neblabs_collection([get_post_meta($coupon->id())]));
        (object) ($optionsTemplate = neblabs_collection([$couponUrlData->find(function (array $templates, string $key) {
            return i($key)->is(Env::getWithPrefix('options'));
        })]));
        return $this->couponOptionsFromTemplateFactory->create($optionsTemplate->getValues()->first(), $this->couponOptionsComponent);
    }
}