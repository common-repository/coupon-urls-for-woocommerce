<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;
class PassedCollection implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $collection;
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }
    public function get() : Collection
    {
        return $this->collection;
    }
}