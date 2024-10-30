<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use function CouponURLs\Original\Utilities\Collection\a;
return ['woocommerce_after_calculate_totals' => ['CouponURLs\\App\\Subscribers\\ScheduledCouponsApplier', 'CouponURLs\\App\\Subscribers\\CouponsToBeAppliedRemover'], 'woocommerce_cart_totals_before_order_total' => ['CouponURLs\\App\\Subscribers\\CouponsToBeAppliedTableRenderer'], 'wp_loaded' => ['CouponURLs\\App\\Subscribers\\ActionsRegistratorForCurrentURL', 'CouponURLs\\App\\Subscribers\\RequestActionsRunner', 'CouponURLs\\App\\Subscribers\\TestDependenciesExposer']];