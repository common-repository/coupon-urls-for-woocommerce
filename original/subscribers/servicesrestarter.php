<?php

namespace CouponURLs\Original\Subscribers;

use CouponURLs\Original\Core\Abilities\ServicesContainer;
use CouponURLs\Original\Core\Application;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Parts\EmptyCustomArguments;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use function CouponURLs\Original\Utilities\Collection\_;
class ServicesRestarter implements Subscriber
{
    /**
     * @var \CouponURLs\Original\Core\Application
     */
    protected $application;
    use DefaultPriority, EmptyCustomArguments;
    public function __construct(Application $application)
    {
        $this->application = $application;
    }
    public function validator() : Validator
    {
        (bool) ($itsTheSecondTimeInitHasBeenCalled = did_action('init') > 1);
        return new ValidWhen($itsTheSecondTimeInitHasBeenCalled);
    }
    public function execute() : void
    {
        $this->application->stop();
        $this->application->start();
    }
}