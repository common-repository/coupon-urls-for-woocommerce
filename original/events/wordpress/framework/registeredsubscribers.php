<?php

namespace CouponURLs\Original\Events\Wordpress\Framework;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\GettableCollectionDecorator;
use function CouponURLs\Original\Utilities\Collection\_;
class RegisteredSubscribers implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $subscriberGetters;
    public function __construct(Collection $subscriberGetters)
    {
        $this->subscriberGetters = $subscriberGetters;
    }
    public function get() : Collection
    {
        (object) ($subscribers = neblabs_collection([]));
        $this->subscriberGetters->forEvery(function (GettableCollection $subscriberGetter) use ($subscribers) {
            return $subscribers->append($subscriberGetter->get()->ungroup());
        });
        return $subscribers->group();
        ////---------------------------------------------
        ///
        ///
        ///-------------------------
        (object) ($originalSubscribers = $this->originalSubscribersGetter->get());
        (object) ($appSubscribers = $this->appSubscribersGetter->get());
        return $originalSubscribers->ungroup()->append($appSubscribers->ungroup())->group();
    }
}