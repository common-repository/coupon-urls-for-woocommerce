<?php

namespace CouponURLs\Original\Data\Model;

use CouponURLs\Original\Data\Schema\DatabaseTable;
abstract class Model
{
    public abstract function getDomainClass() : string;
    public abstract function getDomainsClass() : string;
    public abstract function getSchema() : Schema;
}