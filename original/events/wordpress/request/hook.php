<?php

namespace CouponURLs\Original\Events\Wordpress\Request;

use CouponURLs\Original\Events\Subscriber;
abstract class Hook
{
    /**
     * @var string
     */
    protected $name;
    public abstract function type() : string;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function name() : string
    {
        return $this->name;
    }
}