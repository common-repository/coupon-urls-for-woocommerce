<?php

namespace CouponURLs\Original\Creation\Abilities;

use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;
use Throwable;
interface HandlesCreatableEntitiesExceptions
{
    /**
     * @param mixed $data
     */
    public function handleCreateEntityException(Throwable $exception, $data) : ?Entity;
    /**
     * @param mixed $entitesData
     */
    public function handleCreateEntitiesException(Throwable $exception, $entitesData) : ?Entities;
}