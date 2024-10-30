<?php

namespace CouponURLs\Original\Creation\Entities\Abilities;

interface OverloadableEntitiesFactory
{
    /**
     * @param mixed $data
     */
    public function canCreateEntities($data) : bool;
    /**
     * @param mixed $data
     */
    public function canCreateEntity($data) : bool;
}