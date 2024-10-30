<?php
namespace CouponURLs\App\Domain\Actions\Messages;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Carts\Cart;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\App\Domain\Redirections\Abilities\Redirectable;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

Class CouponAddedToCartExtraNotificationMessage implements Actionable, RestrictableAction
{
    /**
     * @var string
     */
    protected $message;
    /**
     * @var \CouponURLs\App\Domain\Carts\Cart
     */
    protected $cart;
    /**
     * @var \CouponURLs\App\Domain\Coupons\Coupon
     */
    protected $coupon;
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $_;
    public function __construct(string $message, Cart $cart, Coupon $coupon, GlobalFunctionWrapper $_ = null)
    {
        $_ = $_ ?? new GlobalFunctionWrapper;
        $this->message = $message;
        $this->cart = $cart;
        $this->coupon = $coupon;
        $this->_ = $_;
    }
    
    public function canPerform(): Validator
    {
        return new ValidWhen($this->cart->hasAddedCoupon($this->coupon));
    } 

    public function perform(): void
    {
        wc_add_notice(
            $this->message,
            'success',
            [$this->coupon->code()->get()]
        );
    } 
}