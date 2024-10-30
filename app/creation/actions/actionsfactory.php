<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Components\Components;
use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\CouponURLs\CouponURL;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Environment\Env;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;
class ActionsFactory implements CreatableFromCouponUrl
{
    /**
     * @var \CouponURLs\App\Components\Components
     */
    protected $actionComponents;
    /**
     * @var \CouponURLs\Original\Construction\FactoryOverloader
     */
    protected $actionsFactoryOverloader;
    /**
     * @var \CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory
     */
    protected $optionsFromTemplateAndOptionableFactory;
    public function __construct(Components $actionComponents, FactoryOverloader $actionsFactoryOverloader, OptionsFromTemplateAndOptionableFactory $optionsFromTemplateAndOptionableFactory)
    {
        $this->actionComponents = $actionComponents;
        $this->actionsFactoryOverloader = $actionsFactoryOverloader;
        $this->optionsFromTemplateAndOptionableFactory = $optionsFromTemplateAndOptionableFactory;
    }
    public function createFromCoupon(Coupon $coupon) : object
    {
        (object) ($couponUrlData = neblabs_collection([get_post_meta($coupon->id())]));
        (object) ($actionTypes = []);
        (object) ($onlyActionsData = function (array $values, string $key) {
            return i($key)->startsWith(Env::getWithPrefix('action'));
        });
        (object) ($onlyValidActions = function ($value, string $actionType) {
            return $this->actionComponents->has($actionType);
        });
        return $couponUrlData->filter($onlyActionsData)->mapWithKeys(function (array $values, string $key) {
            return ['key' => i($key)->replace(Env::getWithPrefix('action_'), '')->get(), 'value' => $values[0]];
        })->filter($onlyValidActions)->map(function ($options, string $actionType) use ($coupon) {
            return $this->createFromType($actionType, $options, $coupon);
        });
    }
    public function createFromType(string $actionType, string $options, Coupon $coupon) : Actionable
    {
        /** @var ActionFromCouponAndMappedObjectFactory */
        (object) ($actionFactory = $this->actionsFactoryOverloader->overload($actionType));
        return $actionFactory->create($coupon, $this->optionsFromTemplateAndOptionableFactory->create($options, $this->actionComponents->withId($actionType)));
    }
}