<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use function CouponURLs\Original\Utilities\Collection\a;
return ['admin_enqueue_scripts' => ['CouponURLs\\App\\Subscribers\\DashboardScriptsRegistrator'], 'wp_loaded' => ['CouponURLs\\App\\Subscribers\\PostTypeSearchTitleFilter'], 'save_post' => ['CouponURLs\\App\\Subscribers\\CouponURLsDataSaver'], 'admin_init' => ['CouponURLs\\App\\Subscribers\\PluginScreenActionButtonsRegistrator']];