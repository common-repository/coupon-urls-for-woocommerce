<?php

namespace CouponURLs\Original\Construction\Language;

use ReflectionClass;
class TypeReflectionFactory
{
    public function create(string $type) : ReflectionClass
    {
        (bool) ($checkForExistenceWhileAutoloadingIt = class_exists($type));
        if ($checkForExistenceWhileAutoloadingIt) {
            return new ReflectionClass($type);
        }
    }
}