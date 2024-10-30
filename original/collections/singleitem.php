<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;
use function CouponURLs\Original\Utilities\Collection\_;
class SingleItem implements GettableCollection
{
    /**
     * @var mixed
     */
    protected $item;
    /**
     * @param mixed $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }
    public function get() : Collection
    {
        return neblabs_collection([$this->item]);
    }
}