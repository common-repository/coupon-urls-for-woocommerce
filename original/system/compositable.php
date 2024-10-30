<?php

namespace CouponURLs\Original\System;

class Compositable
{
    private $objects;
    public function __construct(iterable $objects)
    {
        $this->objects = $objects;
    }
    public function execute(string $method, array $arguments = [])
    {
        foreach ($this->objects as $object) {
            $object->{$method}(...$arguments);
        }
    }
    public function __call($name, $arguments)
    {
        return $this->execute($name, $arguments);
    }
}