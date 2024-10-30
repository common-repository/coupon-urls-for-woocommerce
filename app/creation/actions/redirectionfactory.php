<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Creation\Actions\ActionFromCouponAndMappedObjectFactory;
use CouponURLs\App\Domain\Actions\Redirections\Redirection;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Redirections\CartURL;
use CouponURLs\App\Domain\Redirections\CheckoutURL;
use CouponURLs\App\Domain\Redirections\HomePageURL;
use CouponURLs\App\Domain\Redirections\PlainURL;
use CouponURLs\App\Domain\Redirections\PostTypeRedirectionValidator;
use CouponURLs\App\Domain\Redirections\PostTypeURL;
use CouponURLs\App\Domain\Redirections\RelativeURL;
use CouponURLs\App\Domain\Redirections\ShopURL;
use CouponURLs\App\Domain\Redirections\WordPressURLRedirector;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;
use CouponURLs\Original\System\NativeExiter;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use function CouponURLs\Original\Utilities\Collection\_;
class RedirectionFactory implements FactoryWithVariableArguments, ActionFromCouponAndMappedObjectFactory
{
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    public function create(Coupon $coupon, MappedObject $options) : \CouponURLs\App\Domain\Abilities\Actionable
    {
        switch ($options->type->get()) {
            case 'cart':
                $redirectionObjects = $this->createCartRedirectionObjects($options);
                break;
            case 'checkout':
                $redirectionObjects = $this->createCheckoutRedirectionObjects($options);
                break;
            case 'shop':
                $redirectionObjects = $this->createShopRedirectionObjects($options);
                break;
            case 'postType':
                $redirectionObjects = $this->createPostTypeRedirectionObjects($options);
                break;
            case 'homepage':
                $redirectionObjects = $this->createHomePageRedirectionObjects($options);
                break;
            case 'path':
                $redirectionObjects = $this->createRelativeURLRedirectionObjects($options);
                break;
            case 'url':
                $redirectionObjects = $this->createURLRedirectionObjects($options);
                break;
        }
        return new Redirection(new WordPressURLRedirector(...array_merge($redirectionObjects->getValues()->asArray(), [new NativeExiter()])));
    }
    protected function createCartRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new CartURL(), 'redirectionValidator' => new PassingValidator()]);
    }
    protected function createCheckoutRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new CheckoutURL(), 'redirectionValidator' => new passingValidator()]);
    }
    protected function createShopRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new ShopURL(), 'redirectionValidator' => new passingValidator()]);
    }
    protected function createPostTypeRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new PostTypeURL((int) $options->value->get()), 'redirectionValidator' => new PostTypeRedirectionValidator((int) $options->value->get())]);
    }
    protected function createHomePageRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new HomePageURL($options->value), 'redirectionValidator' => new PassingValidator()]);
    }
    protected function createRelativeURLRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new RelativeURL($options->value), 'redirectionValidator' => new PassingValidator()]);
    }
    protected function createURLRedirectionObjects(MappedObject $options) : Collection
    {
        return neblabs_collection(['url' => new PlainURL($options->value), 'redirectionValidator' => new PassingValidator()]);
    }
}