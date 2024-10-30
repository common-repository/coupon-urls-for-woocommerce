<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Data\Finders\Couponurls\CouponURLsFinder;
use CouponURLs\App\Domain\Actions\ActionsComposite;
use CouponURLs\App\Domain\CouponURLs\CouponURL;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use function CouponURLs\Original\Utilities\Collection\_;
class ActionsRegistratorForCurrentURL implements Subscriber
{
    /**
     * @var \CouponURLs\App\Data\Finders\Couponurls\CouponURLsFinder
     */
    protected $couponURLsFinder;
    /**
     * @var \CouponURLs\App\Domain\Actions\ActionsComposite
     */
    protected $actions;
    /**
     * @var \CouponURLs\App\Domain\Uris\Abilities\URI
     */
    protected $requestURI;
    public function priority() : int
    {
        return 6;
    }
    public function __construct(CouponURLsFinder $couponURLsFinder, ActionsComposite $actions, URI $requestURI)
    {
        $this->couponURLsFinder = $couponURLsFinder;
        $this->actions = $actions;
        $this->requestURI = $requestURI;
    }
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(neblabs_collection(['couponURLForThisRequest' => $this->couponURLsFinder->matchingURI($this->requestURI)->findThem()->asCollection()->first()]));
    }
    public function validator(?CouponURL $couponURLForThisRequest = null) : Validator
    {
        return new Validators([new ValidWhen($couponURLForThisRequest instanceof CouponURL), new ValidWhen(function () use ($couponURLForThisRequest) {
            return $couponURLForThisRequest->canRunActions();
        })]);
    }
    public function execute(CouponURL $couponURLForThisRequest) : void
    {
        $couponURLForThisRequest->actions->forEvery(\Closure::fromCallable([$this->actions, 'add']));
    }
}