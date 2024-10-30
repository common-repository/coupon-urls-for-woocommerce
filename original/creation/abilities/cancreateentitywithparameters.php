<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entity;
interface CanCreateEntityWithParameters
{
    /**
     * @param mixed $data
     */
    public function createEntity($data, Parameters $parameters) : Entity;
}