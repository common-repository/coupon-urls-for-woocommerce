<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Components\Actions\Builtin\AddCouponComponent;
use CouponURLs\App\Components\Actions\Builtin\AddProductComponent;
use CouponURLs\App\Components\Components;
use CouponURLs\App\Creation\Actions\ActionsFactory;
use CouponURLs\App\Creation\Actions\AddCouponFactory;
use CouponURLs\App\Creation\Actions\AddProductFactory;
use CouponURLs\App\Creation\Actions\CouponAddedToCartExtraNotificationMessageFactory;
use CouponURLs\App\Creation\Actions\CouponToBeAddedNotificationMessageFactory;
use CouponURLs\App\Creation\Actions\OverloadableFactoryById;
use CouponURLs\App\Creation\Actions\RedirectionFactory;
use CouponURLs\App\Creation\OptionsFromTemplateAndOptionableFactory;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use function CouponURLs\Original\Utilities\Collection\_;
class ActionsFactoryDependency implements Cached, StaticType, Dependency
{
    /**
     * @var \CouponURLs\App\Components\Components
     */
    protected $actionComponents;
    /**
     * @var \CouponURLs\App\Creation\Actions\AddCouponFactory
     */
    protected $addCouponFactory;
    /**
     * @var \CouponURLs\App\Creation\Actions\AddProductFactory
     */
    protected $addProductFactory;
    /**
     * @var \CouponURLs\App\Creation\Actions\RedirectionFactory
     */
    protected $redirectionFactory;
    /**
     * @var \CouponURLs\App\Creation\Actions\CouponAddedToCartExtraNotificationMessageFactory
     */
    protected $couponAddedToCartExtraNotificationMessageFactory;
    /**
     * @var \CouponURLs\App\Creation\Actions\CouponToBeAddedNotificationMessageFactory
     */
    protected $couponToBeAddedNotificationMessageFactory;
    use WillAlwaysMatch;
    public function __construct(Components $actionComponents, AddCouponFactory $addCouponFactory, AddProductFactory $addProductFactory, RedirectionFactory $redirectionFactory, CouponAddedToCartExtraNotificationMessageFactory $couponAddedToCartExtraNotificationMessageFactory, CouponToBeAddedNotificationMessageFactory $couponToBeAddedNotificationMessageFactory)
    {
        $this->actionComponents = $actionComponents;
        $this->addCouponFactory = $addCouponFactory;
        $this->addProductFactory = $addProductFactory;
        $this->redirectionFactory = $redirectionFactory;
        $this->couponAddedToCartExtraNotificationMessageFactory = $couponAddedToCartExtraNotificationMessageFactory;
        $this->couponToBeAddedNotificationMessageFactory = $couponToBeAddedNotificationMessageFactory;
    }
    public static function type() : string
    {
        return ActionsFactory::class;
    }
    public function create() : object
    {
        return new ActionsFactory($this->actionComponents, new FactoryOverloader(neblabs_collection([new OverloadableFactoryById($this->actionComponents->withId('AddCoupon'), $this->addCouponFactory), new OverloadableFactoryById($this->actionComponents->withId('AddProduct'), $this->addProductFactory), new OverloadableFactoryById($this->actionComponents->withId('Redirection'), $this->redirectionFactory), new OverloadableFactoryById($this->actionComponents->withId('CouponToBeAddedNotificationMessage'), $this->couponToBeAddedNotificationMessageFactory), new OverloadableFactoryById($this->actionComponents->withId('CouponAddedToCartExtraNotificationMessage'), $this->couponAddedToCartExtraNotificationMessageFactory)])), new OptionsFromTemplateAndOptionableFactory());
    }
}