<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Components\Options\CouponOptionsComponent;
use CouponURLs\App\Creation\Coupons\CouponOptionsFromCouponFactory;
use CouponURLs\App\Creation\Coupons\CouponOptionsFromTemplateFactory;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;

class OptionsFactoryDependency implements Cached, StaticType, Dependency
{
    /**
     * @var \CouponURLs\App\Components\Options\CouponOptionsComponent
     */
    protected $couponOptionsComponent;
    use WillAlwaysMatch;

    public function __construct(CouponOptionsComponent $couponOptionsComponent)
    {
        $this->couponOptionsComponent = $couponOptionsComponent;
    }
    
    static public function type(): string
    {
        return CouponOptionsFromCouponFactory::class;   
    } 

    public function create(): object
    {
        return new CouponOptionsFromCouponFactory($this->couponOptionsComponent, new OptionsFromTemplateAndOptionableFactory);
    } 
}