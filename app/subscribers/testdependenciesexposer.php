<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Creation\Actions\ActionsFactory;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use function CouponURLs\Original\Utilities\Collection\_;
class TestDependenciesExposer implements Subscriber
{
    /**
     * @var \CouponURLs\App\Creation\Actions\ActionsFactory
     */
    protected $actionsFactory;
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    use DefaultPriority;
    use EmptyCustomArguments;
    public function __construct(ActionsFactory $actionsFactory, Cart $cart, CouponsToBeAdded $couponsToBeAdded)
    {
        $this->actionsFactory = $actionsFactory;
        $this->cart = $cart;
        $this->couponsToBeAdded = $couponsToBeAdded;
    }
    public function validator() : Validator
    {
        return new ValidWhen(Env::settings()->environment !== 'production');
    }
    public function execute() : void
    {
        add_filter('ActionsFactory', function () {
            return $this->actionsFactory;
        });
        add_filter('Cart', function () {
            return $this->cart;
        });
        add_filter('CouponsToBeAdded', function () {
            return $this->couponsToBeAdded;
        });
    }
}