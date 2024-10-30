<?php
namespace CouponURLs\App\Domain\Actions\Messages;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Abilities\RestrictableAction;
use CouponURLs\App\Domain\Coupons\Coupon;
use CouponURLs\App\Domain\Coupons\CouponsToBeAdded;
use CouponURLs\App\Domain\Redirections\Abilities\Redirectable;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;

Class CouponToBeAddedNotificationMessage implements Actionable, RestrictableAction
{
    /**
     * @var string
     */
    protected $message;
    /**
     * @var \CouponURLs\App\Domain\Coupons\CouponsToBeAdded
     */
    protected $couponsToBeAdded;
    /**
     * @var \CouponURLs\App\Domain\Coupons\Coupon
     */
    protected $coupon;
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $_;
    public function __construct(string $message, CouponsToBeAdded $couponsToBeAdded, Coupon $coupon, GlobalFunctionWrapper $_ = null)
    {
        $_ = $_ ?? new GlobalFunctionWrapper;
        $this->message = $message;
        $this->couponsToBeAdded = $couponsToBeAdded;
        $this->coupon = $coupon;
        $this->_ = $_;
    }
    
    public function canPerform(): Validator
    {
        return new ValidWhen($this->couponsToBeAdded->hasAddedToTheQueue($this->coupon));
    } 

    public function perform(): void
    {
        wc_add_notice(
            $this->message,
            'notice',
            [$this->coupon->code()->get()]
        );
    } 
}