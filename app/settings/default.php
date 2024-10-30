<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return (object) array('app' => (object) array('id' => 'coupon_urls', 'shortId' => 'cpu', 'namespace' => 'CouponURLs', 'pluginFileName' => 'coupon-urls', 'textDomain' => 'coupon-urls-for-woocommerce', 'translationFiles' => (object) array('production' => 'international/coupon-urls-for-woocommerce.pot', 'main' => 'international/main-source.pot', 'scripts' => 'international/scripts-source.pot')), 'events' => (object) array('globalValidator' => 'CouponURLs\\App\\Events\\CustomGlobalEventsValidator'), 'schema' => (object) array('applicationDatabase' => 'CouponURLs\\App\\Data\\Schema\\ApplicationDatabase'), 'directories' => (object) array('main' => 'coupon-urls', 'app' => (object) array('schema' => 'data/schema', 'scripts' => 'scripts', 'dashboard' => 'scripts/dashboard'), 'storage' => (object) array('branding' => 'storage/branding')), 'environment' => 'production', 'tests' => (object) array('loadPlugins' => array(0 => 'woocommerce/woocommerce.php')), 'binaries' => (object) array('php' => '/opt/local/bin/php', 'phpunit' => './vendor/bin/phpunit'));