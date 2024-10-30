<?php

namespace CouponURLs\App\Domain\Products;

use WC_Product;
use WC_Product_Variable;
use WC_Product_Variation;

use function CouponURLs\Original\Utilities\Text\i;

class Product
{
    /**
     * @var \WC_Product|\WC_Product_Variation|\WC_Product_Variable
     */
    public $classic;
    /**
     * @param \WC_Product|\WC_Product_Variation|\WC_Product_Variable $classic
     */
    public function __construct($classic)
    {
        $this->classic = $classic;
    }
    
    /**
     * @param string|\CouponURLs\App\Domain\Products\Product $typeOrProduct
     */
    public function is($typeOrProduct) : bool
    {
        switch (true) {
            case $typeOrProduct instanceof Product:
                return $this->checkIsProduct($typeOrProduct);
            default:
                return i($this->classic->get_type())->is($typeOrProduct);
        }
    }

    protected function checkIsProduct(Product $product) : bool
    {
        return $product->classic->get_id() === $this->classic->get_id() &&
               $product->classic->get_parent_id() === $this->classic->get_parent_id();

    }
    
}