<?php

namespace CouponURLs\Original\Dependency\Builtin;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Collections\Abilities\ValidatableGettableCollection;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\OnlyValidGroupedGettableCollectionComposite;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Events\Wordpress\Framework\AppSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\FileSubscribersGetter;
use CouponURLs\Original\Events\Wordpress\Framework\OriginalSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\RegisteredSubscribers;
use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Events\Wordpress\Framework\AppBackendSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\AppBackendSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\AppFrontEndSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\AppFrontEndSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\AppGlobalSubscribers;
use CouponURLs\Original\Events\Wordpress\Framework\AppGlobalSubscribersSource;
use CouponURLs\Original\Events\Wordpress\Framework\BackendAppSubscribers;
use function CouponURLs\Original\Utilities\Collection\_;
class RegisteredSubscribersDependency implements Cached, StaticType, Dependency
{
    public static function type() : string
    {
        return RegisteredSubscribers::class;
    }
    public function canBeCreated(Context $context) : bool
    {
        return true;
    }
    public function create() : object
    {
        return new RegisteredSubscribers(neblabs_collection([new ByFileGettableCollection(new OriginalSubscribers()), new OnlyValidGroupedGettableCollectionComposite(neblabs_collection([new AppGlobalSubscribers(new AppGlobalSubscribersSource()), new AppBackendSubscribers(new AppBackendSubscribersSource()), new AppFrontEndSubscribers(new AppFrontEndSubscribersSource())]))]));
    }
}