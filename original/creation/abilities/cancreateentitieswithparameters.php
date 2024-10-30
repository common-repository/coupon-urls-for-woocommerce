<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entities;
interface CanCreateEntitiesWithParameters
{
    /**
     * @param mixed $entitesData
     */
    public function createEntities($entitesData, Parameters $parameters) : Entities;
}