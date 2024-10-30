<?php

namespace CouponURLs\Original\Data\Schema\DatabaseColumn;

use CouponURLs\Original\Characters\StringManager;
abstract class DatabaseColumnDefault
{
    protected $value;
    public abstract function getDefinition();
    public function __construct($value = null)
    {
        $this->value = $value;
    }
    protected function getCleanValue()
    {
        return (new StringManager($this->value))->getOnly('A-Za-z0-9_() ');
    }
}