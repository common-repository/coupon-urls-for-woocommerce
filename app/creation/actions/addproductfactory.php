<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Products\AddProduct;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Carts\CartItem;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Products\Product;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;

class AddProductFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    public function create(Coupon $coupon, MappedObject $options): \CouponURLs\App\Domain\Abilities\Actionable
    {
        return new AddProduct(
            new CartItem(
                new Product(wc_get_product($options->id)),
                $options->quantity
            ),
            $coupon,
            $this->cart
        );
    } 
}