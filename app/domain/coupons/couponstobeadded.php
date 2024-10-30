<?php

namespace CouponURLs\App\Domain\Coupons;

use CouponURLs\App\Creation\Coupons\CouponsFactory;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\Coupons;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use WC_Session_Handler;
use function CouponURLs\Original\Utilities\Collection\_;
class CouponsToBeAdded
{
    /**
     * @var \WC_Session_Handler
     */
    protected $session;
    /**
     * @var \CouponURLs\App\Creation\Coupons\CouponsFactory
     */
    protected $couponsFactory;
    #The coupons added to the current instance by calling static::add()
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $couponCodesAddedToQueue;
    public function __construct(WC_Session_Handler $session, CouponsFactory $couponsFactory, ?Collection $couponCodes = null)
    {
        $this->session = $session;
        $this->couponsFactory = $couponsFactory;
        if ($couponCodes || !$this->session->get($this->key())) {
            $this->setCouponCodes($couponCodes ?? neblabs_collection([]));
        }
        $this->couponCodesAddedToQueue = neblabs_collection([]);
    }
    public function coupons() : Coupons
    {
        return $this->couponsFactory->createFromCodes($this->couponCodes());
    }
    /**
     * READONLY COPY, MODIFYING THIS DIRECTLY WILL HAVE NO EFFECT!
     */
    public function couponCodes() : Collection
    {
        return neblabs_collection([$this->session->get($this->key())]);
    }
    public function has(Coupon $coupon) : bool
    {
        return $this->couponCodes()->have($coupon->code());
    }
    public function hasAddedToTheQueue(Coupon $coupon) : bool
    {
        return $this->couponCodesAddedToQueue->have($coupon->code());
    }
    public function add(Coupon $coupon) : void
    {
        $this->couponCodesAddedToQueue->push($coupon->code());
        $this->setCouponCodes($this->couponCodes()->push($coupon->code()->get())->withoutDuplicates());
    }
    public function remove(Coupon $coupon) : void
    {
        $this->setCouponCodes($this->couponCodes()->filter(function (string $couponCode) use ($coupon) {
            return !$coupon->code()->is($couponCode);
        })->getValues());
    }
    protected function setCouponCodes(Collection $couponCodes) : void
    {
        if ($couponCodes->filter()->haveAny() && !$this->session->has_session()) {
            $this->session->set_customer_session_cookie(true);
        }
        $this->session->set($this->key(), $couponCodes->filter()->asArray());
        $this->session->save_data();
    }
    protected function key() : string
    {
        return Env::getWithPrefix('coupons_to_be_added');
    }
}