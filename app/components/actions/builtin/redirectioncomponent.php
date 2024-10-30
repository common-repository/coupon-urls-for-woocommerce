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
class RedirectionComponent implements Identifiable, Nameable, HasInlineOptions, Descriptables
{
    public function identifier() : string
    {
        return 'Redirection';
    }
    public function name()
    {
        return \__('Redirect', 'coupon-urls-for-woocommerce');
    }
    public function descriptions() : Collection
    {
        return neblabs_collection([\__("This action will always be executed after all others", 'coupon-urls-for-woocommerce')]);
    }
    public function options() : Collection
    {
        return neblabs_collection(['type' => TYPES::STRING()->allowed(['cart', 'checkout', 'shop', 'homepage', 'postType', 'path', 'url'])->meta(['field' => ['labels' => ['top' => \__('To', 'coupon-urls-for-woocommerce')]], 'values' => [['value' => 'cart', 'name' => 'Cart', 'description' => 'The WooCommerce Cart Page'], ['value' => 'checkout', 'name' => 'Checkout', 'description' => 'The WooCommerce Checkout Page'], ['value' => 'shop', 'name' => 'Shop', 'description' => 'The WooCommerce Main Shop Page'], ['value' => 'homepage', 'name' => 'HomePage', 'description' => "The site's Home Page"], ['value' => 'postType', 'name' => 'Page', 'description' => 'Any page (including posts, pages and products)'], ['value' => 'path', 'name' => 'Custom Path', 'description' => 'A relative path on this site (a path after your homepage url)'], ['value' => 'url', 'name' => 'URL', 'description' => 'Any URL']]]), 'value' => TYPES::STRING()->meta(['dynamicFields' => [['when' => ['field' => 'type', 'operator' => '==', 'value' => 'path'], 'field' => ['labels' => ['top' => \__('Path relative to the homepage', 'coupon-urls-for-woocommerce')], 'placeholder' => \__('/path/to/use/', 'coupon-urls-for-woocommerce'), 'width' => 'full']], ['when' => ['field' => 'type', 'operator' => '==', 'value' => 'url'], 'field' => ['labels' => ['top' => \__('URL to redirect to', 'coupon-urls-for-woocommerce')], 'placeholder' => \__('https://google.com', 'coupon-urls-for-woocommerce'), 'width' => 'full']], ['when' => ['field' => 'type', 'operator' => '==', 'value' => 'postType'], 'field' => ['searchable' => ['url' => esc_url(admin_url('admin-ajax.php')), 'method' => 'POST', 'data' => ['action' => 'wp-link-ajax', '_ajax_linking_nonce' => esc_html(wp_create_nonce('internal-linking')), 'search' => '((value))']], 'labels' => ['top' => \__('Page (post type) name', 'coupon-urls-for-woocommerce')], 'placeholder' => \__('Page name...', 'coupon-urls-for-woocommerce'), 'width' => 'full']]]])]);
    }
}