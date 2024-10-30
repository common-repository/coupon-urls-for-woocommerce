<?php

namespace CouponURLs\Original\Language;

class CallableBuilder
{
    /**
     * @var object
     */
    protected $object;
    public function __construct(object $object)
    {
        $this->object = $object;
    }
    public function __call($name, $arguments) : callable
    {
        $bindedArguments = $arguments;
        return function (...$callbackArguments) use ($name, $bindedArguments) {
            return $this->object->{$name}(...array_filter(array_merge(is_array($bindedArguments) ? $bindedArguments : iterator_to_array($bindedArguments), $callbackArguments)));
        };
    }
}