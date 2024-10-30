<?php

namespace CouponURLs\Original\Data\Instructions;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
abstract class Instruction
{
    public abstract function shouldGet() : bool;
    protected $statement;
    protected $parameters;
    public function getStatement() : StringManager
    {
        return $this->statement;
    }
    public function getParameters() : Collection
    {
        return $this->parameters;
    }
}