<?php

namespace CouponURLs\Original\System;

class ObjectWrapper
{
    /**
     * @var object
     */
    protected $object;
    public function __construct(object $object)
    {
        $this->object = $object;
    }
    /**
     * @return mixed
     */
    public function call(string $method, ...$arguments)
    {
        // make it an indexed array so that we don't pass named arguments in php less than 8
        if (is_array($arguments)) {
            $arguments = array_values($arguments);
        }
        return $this->object->{$method}(...$arguments);
    }
}