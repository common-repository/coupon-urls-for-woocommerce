<?php

namespace CouponURLs\Original\Characters;

class IntegerManager
{
    protected $numerable;
    protected $number;
    public static function create($numerable)
    {
        return new static($numerable);
    }
    public function __construct($numerable)
    {
        $this->numerable = $numerable;
        $this->number = (int) $numerable;
    }
    public function twoDigit()
    {
        return $this->numerable < 10 && strlen((string) $this->numerable) < 2 ? "0{$this->numerable}" : $this->numerable;
    }
}