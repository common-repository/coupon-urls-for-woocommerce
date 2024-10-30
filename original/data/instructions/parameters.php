<?php

namespace CouponURLs\Original\Data\Instructions;

use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class Parameters
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $parameters;
    public function __construct()
    {
        $this->parameters = neblabs_collection([]);
    }
    public function addParameter(Parameter $parameter) : void
    {
        $this->parameters->add($parameter);
    }
}