<?php

namespace CouponURLs\Original\Abilities;

use Attribute;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
#[Attribute]
class Methods
{
    /**
     * @var mixed[]
     */
    protected $names;
    public function __construct(array $names)
    {
        $this->names = $names;
    }
    public function names() : Collection
    {
        return neblabs_collection([$this->names]);
    }
}