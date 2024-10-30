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
class AddProductComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier() : string
    {
        return 'AddProduct';
    }
    public function name()
    {
        return \__('Add Product', 'coupon-urls-for-woocommerce');
    }
    public function descriptions() : Collection
    {
        return neblabs_collection([\__("The product will only be added if it isn't in the cart already", 'coupon-urls-for-woocommerce')]);
    }
    public function options() : Collection
    {
        return neblabs_collection(['quantity' => TYPES::INTEGER()->withDefault(1)->meta(['field' => ['labels' => ['left' => \__('Quantity', 'coupon-urls-for-woocommerce')]]]), 'id' => TYPES::INTEGER()->meta(['name' => 'ID'])->meta(['field' => ['searchable' => ['url' => esc_url(admin_url('admin-ajax.php')), 'data' => ['action' => 'woocommerce_json_search_products_and_variations', 'security' => esc_html(wp_create_nonce('search-products')), 'term' => '((value))']]]])]);
    }
}