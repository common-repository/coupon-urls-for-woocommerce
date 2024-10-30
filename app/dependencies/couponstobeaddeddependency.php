<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Creation\Coupons\CouponsFactory;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;

class CouponsToBeAddedDependency implements Cached, StaticType, Dependency
{
    /**
     * @var \CouponURLs\App\Creation\Coupons\CouponsFactory
     */
    protected $couponsFactory;
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    use WillAlwaysMatch;

    public function __construct(CouponsFactory $couponsFactory, Cart $cart)
    {
        $this->couponsFactory = $couponsFactory;
        $this->cart = $cart;
    }
    
    static public function type(): string
    {
        return CouponsToBeAdded::class;   
    } 

    public function create(): object
    {
        return new CouponsToBeAdded(wc()->session, $this->couponsFactory);
    } 
}