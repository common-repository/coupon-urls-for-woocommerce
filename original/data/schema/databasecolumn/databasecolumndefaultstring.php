<?php

namespace CouponURLs\Original\Data\Schema\DatabaseColumn;

use CouponURLs\Original\Data\Schema\DatabaseColumn\DatabaseColumnDefault;
class DatabaseColumnDefaultString extends DatabaseColumnDefault
{
    public function getDefinition()
    {
        return "DEFAULT '{$this->getCleanValue()}'";
    }
}