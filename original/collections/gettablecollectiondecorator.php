<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Collection;
/**
 * Though not obvious at first, this class
 * allows you to merge an infinite number of collections
 */
class GettableCollectionDecorator implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Abilities\GettableCollection
     */
    protected $parentGettableCollection;
    /**
     * @var \CouponURLs\Original\Abilities\GettableCollection
     */
    protected $childGettableCollection;
    public function __construct(GettableCollection $parentGettableCollection, GettableCollection $childGettableCollection)
    {
        $this->parentGettableCollection = $parentGettableCollection;
        $this->childGettableCollection = $childGettableCollection;
    }
    public function get() : Collection
    {
        return $this->parentGettableCollection->get()->append($this->childGettableCollection->get());
    }
}