<?php

namespace CouponURLs\App\Domain\Coupons;

use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\Original\Domain\Entities;
class Coupons extends Entities
{
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    public function withCart(Cart $cart) : self
    {
        $this->cart = $cart;
        return $this;
    }
    protected function getDomainClass() : string
    {
        return Coupon::class;
    }
    public function onlyValid() : self
    {
        return new static($this->entities->getThoseThat(['canBeApplied' => null]));
    }
    public function applyValidTo(Cart $cart) : void
    {
        (object) ($readyToBeAdded = $this->onlyValid()->asCollection());
        $readyToBeAdded->forEvery(\Closure::fromCallable([$cart, 'add']));
    }
}