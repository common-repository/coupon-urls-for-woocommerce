<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Domain\Entity;
interface CanCreateEntity
{
    /**
     * @param mixed $data
     */
    public function createEntity($data) : Entity;
}