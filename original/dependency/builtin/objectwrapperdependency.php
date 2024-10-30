<?php

namespace CouponURLs\Original\Dependency\Builtin;

use CouponURLS\Original\Dependency\Abilities\StaticType;
use CouponURLS\Original\Dependency\Dependency;
use CouponURLS\Original\Abilities\Cached;
use CouponURLS\Original\Dependency\Abilities\Context;
use CouponURLS\Original\System\ObjectWrapper;
class ObjectWrapperDependency implements Cached, StaticType, Dependency
{
    public static function type() : string
    {
        return ObjectWrapper::class;
    }
    /**
     * @param \CouponURLS\Original\Dependency\Abilities\Context $context
     */
    public function canBeCreated($context) : bool
    {
        return $context->nameIs('wordpressDatabaseWrapper');
    }
    public function create() : object
    {
        global $wpdb;
        return new ObjectWrapper($wpdb);
    }
}