<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Domain\Abilities\Actionable;
use CouponURLs\App\Domain\Actions\ActionsComposite;
use CouponURLs\App\Domain\Actions\ActionsRunnerComposite;
use CouponURLs\App\Domain\Actions\NonRestrictableActionRunner;
use CouponURLs\App\Domain\Actions\RestrictableActionRunner;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Abilities\Cached;
use function CouponURLs\Original\Utilities\Collection\_;
class ActionsDependency implements Cached, StaticType, Dependency
{
    use WillAlwaysMatch;
    public static function type() : string
    {
        return Actionable::class;
    }
    public function create() : object
    {
        return new ActionsComposite(neblabs_collection([]), new ActionsRunnerComposite(neblabs_collection([new RestrictableActionRunner(), new NonRestrictableActionRunner()])));
    }
}