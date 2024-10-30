<?php

namespace CouponURLs\Original\Cache;

use CouponURLs\Original\Collections\Collection;
abstract class Cache
{
    protected $data;
    public abstract function get($key);
    public abstract function getIfExists($key);
    #: CacheValueResolver
    public function __construct($initialValues = [])
    {
        $this->initialValues = $initialValues;
        $this->reset();
    }
    public function reset()
    {
        $this->data = new Collection($this->initialValues);
    }
}