<?php

namespace CouponURLs\App\Creation\Validators;

use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\DuckInterfaceIsImplemented;
use CouponURLs\Original\Validation\Validators\PassingValidator;

class SubscriberValidatorFactory
{
    /**
     * @var string
     */
    private $environment;
    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    public function create(Subscriber $subscriber) : Validator
    {
        switch ($this->environment) {
            case 'production':
                return new PassingValidator;
            default:
                return new DuckInterfaceIsImplemented(
                    Subscriber::class,
                    get_class($subscriber)
                );
        }
    }
}