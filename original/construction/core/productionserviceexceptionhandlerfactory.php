<?php

namespace CouponURLs\Original\Construction\Core;

use CouponURLs\Original\Construction\Abilities\HandleableServiceExceptionFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Core\Abilities\HandleableServiceException;
use CouponURLs\Original\Core\Exceptions\Handlers\SilentServiceExceptionHandler;
use CouponURLs\Original\Environment\Abilities\Environment;
class ProductionServiceExceptionHandlerFactory implements OverloadableFactory, HandleableServiceExceptionFactory
{
    /** @param mixed $value */
    public function canCreate($value) : bool
    {
        return true;
    }
    public function create() : HandleableServiceException
    {
        return new SilentServiceExceptionHandler();
    }
}