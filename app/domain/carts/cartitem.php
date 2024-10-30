<?php

namespace CouponURLs\App\Domain\Carts;

use CouponURLs\App\Domain\Products\Product;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class CartItem
{
    /**
     * @readonly
     * @var \CouponURLs\App\Domain\Products\Product
     */
    public $product;
    protected $quantity = 1;
    /**
     * @readonly
     * @var \CouponURLs\Original\Collections\Collection
     */
    public $extraData;
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    /**
     * @readonly
     * @var string
     */
    public $key;
    public function __construct(Product $product, $quantity = 1, Collection $extraData = null)
    {
        $extraData = $extraData ?? new Collection();
        $this->product = $product;
        $this->quantity = $quantity;
        $this->extraData = $extraData;
    }
    public function key(Cart $cart) : string
    {
        return $cart->generateItemKey($this);
    }
    public function quantity() : int
    {
        return $this->quantity;
    }
    public function export() : Collection
    {
        return neblabs_collection(['product_id' => $this->product->is('variation') ? $this->product->classic->get_parent_id() : $this->product->classic->get_id(), 'quantity' => $this->quantity, 'variation_id' => $this->product->is('variation') ? $this->product->classic->get_id() : 0, 'variation' => $this->product->is('variation') ? $this->product->classic->get_variation_attributes($with_prefix = false) : [], 'cart_item_data' => $this->extraData->asArray()]);
    }
}