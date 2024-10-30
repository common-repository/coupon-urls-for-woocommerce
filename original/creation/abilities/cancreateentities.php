<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Domain\Entities;
interface CanCreateEntities
{
    /**
     * @param mixed $entitesData
     */
    public function createEntities($entitesData) : Entities;
}