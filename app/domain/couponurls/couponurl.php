<?php

namespace CouponURLs\App\Domain\CouponURLs;

use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\MappedObject;
use CouponURLs\Original\Domain\Entity;

Class CouponURL extends Entity
{
    /**
     * @readonly
     * @var \CouponURLs\App\Domain\Coupons\Coupon
     */
    public $coupon;
    /**
     * @readonly
     * @var \CouponURLs\Original\Collections\Collection
     */
    public $actions;
    /**
     * @readonly
     * @var \CouponURLs\App\Domain\Uris\Abilities\URI
     */
    public $URI;

    /**
     * @readonly
     * @var \CouponURLs\Original\Collections\MappedObject
     */
    protected $options;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function setActions(Collection/*<Actionable>*/ $actions) : void
    {
        $this->actions = $actions;
    }

    public function setOptions(MappedObject $options): void
    {
        $this->options = $options;    
    } 

    public function setURI(URI $URI) : void
    {
        $this->URI = $URI;
    }

    public function canRunActions() : bool
    {
        return $this->actions->haveAny() && $this->options->isEnabled;
    }
}