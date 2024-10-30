<?php

namespace CouponURLs\App\Domain\Carts;

use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Products\Product;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Domain\Entity;
use WC_Cart;
use WC_Product;
use function CouponURLs\Original\Utilities\Collection\_;
class Cart extends Entity
{
    /**
     * @readonly
     * @var \WC_Cart
     */
    public $classic;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $couponsAdded;
    public function __construct(WC_Cart $classic)
    {
        $this->classic = $classic;
        $this->couponsAdded = neblabs_collection([]);
    }
    public function isEmpty() : bool
    {
        return !$this->classic->get_cart_contents();
    }
    /**
     * @param \CouponURLs\App\Domain\Coupons\Coupon|\CouponURLs\App\Domain\Carts\CartItem $couponOrItem
     */
    public function has($couponOrItem) : bool
    {
        switch (true) {
            case $couponOrItem instanceof Coupon:
                return $this->hasCoupon($couponOrItem);
            case $couponOrItem instanceof CartItem:
                return $this->hasItem($couponOrItem);
        }
    }
    public function hasProduct(Product $product) : bool
    {
        return neblabs_collection([$this->classic->get_cart_contents()])->filter(function (array $item) {
            return $item['data'] instanceof WC_Product;
        })->map(function (array $item) : Product {
            return new Product($item['data']);
        })->findTheOneThat(['is' => $product]);
    }
    public function quanititiesOf(Product $product) : int
    {
        return neblabs_collection([$this->classic->get_cart_contents()])->filter(function (array $item) {
            return $item['data'] instanceof WC_Product;
        })->filter(function (array $item) use ($product) {
            return (new Product($item['data']))->is($product);
        })->mapUsing(['quantity' => null])->sum();
    }
    /**
     * @param \CouponURLs\App\Domain\Coupons\Coupon|\CouponURLs\App\Domain\Carts\CartItem $couponOrItem
     */
    public function add($couponOrItem) : void
    {
        switch (true) {
            case $couponOrItem instanceof Coupon:
                $this->addCoupon($couponOrItem);
                break;
            case $couponOrItem instanceof CartItem:
                $this->addItem($couponOrItem);
                break;
        }
    }
    public function hasAddedCoupon(Coupon $coupon) : bool
    {
        return $this->couponsSuccessfullyAdded()->strictlyHave($coupon);
    }
    public function generateItemKey(CartItem $cartItem) : string
    {
        return $this->classic->generate_cart_id(...$cartItem->export()->except(['quantity'])->getValues()->asArray());
    }
    protected function addCoupon(Coupon $coupon) : void
    {
        if ($this->has($coupon)) {
            return;
        }
        if ($this->classic->apply_coupon($coupon->code()->get())) {
            $this->couponsAdded->push($coupon);
        }
    }
    protected function addItem(CartItem $cartItem) : void
    {
        $this->classic->add_to_cart(...$cartItem->export()->getValues()->asArray());
    }
    public function hasCoupon(Coupon $coupon) : bool
    {
        return neblabs_collection([$this->classic->get_applied_coupons()])->have(function (string $couponCode) use ($coupon) {
            return $coupon->code()->is($couponCode);
        });
    }
    public function hasItem(CartItem $item) : bool
    {
        return !$this->isEmpty() && $this->classic->find_product_in_cart($item->key($this));
    }
    // this will only give you the coupons that we added AND that were succesfully
    // added to the cart
    protected function couponsSuccessfullyAdded() : Collection
    {
        return $this->couponsAdded->filter(\Closure::fromCallable([$this, 'has']));
    }
}