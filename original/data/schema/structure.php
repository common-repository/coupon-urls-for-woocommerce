<?php

namespace CouponURLs\Original\Data\Schema;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Schema\Abilities\StructureIdentifier;
abstract class Structure
{
    public abstract function name() : string;
    public abstract function fields() : Fields;
}