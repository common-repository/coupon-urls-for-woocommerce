<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\WillAlwaysExecute;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;
class PluginScreenActionButtonsRegistrator implements Subscriber
{
    use DefaultPriority, WillAlwaysExecute;
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(neblabs_collection([]));
    }
    public function execute() : void
    {
        add_filter('plugin_action_links', function ($actions, $plugin_file, $plugin_data, $context) {
            // Check if this is your plugin
            (object) ($newActions = neblabs_collection([]));
            if (i($plugin_file)->endsWith(Env::settings()->app->pluginFileName . '.php')) {
                $url = admin_url('edit.php?post_type=shop_coupon');
                $newActions->add(Env::getWithPrefix('go_to_coupons'), sprintf('<a href="%s" style="color:#788c0b">%s</a>', esc_url($url), esc_html(\__('Go to Coupons', 'coupon-urls-for-woocommerce'))));
            }
            return $newActions->append($actions)->asArray();
        }, 10, 4);
    }
}