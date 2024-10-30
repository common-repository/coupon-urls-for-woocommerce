<?php

namespace CouponURLs\Original\Domain;

use CouponURLs\Original\Collections\Collection;
abstract class ExtendableEntities extends Entities
{
    /**
     * @param \CouponURLs\Original\Collections\Collection|mixed[] $entities
     */
    public function set($entities) : ExtendableEntities
    {
        $this->setEntities($entities);
        return $this;
    }
    public function append(Entity $entity) : ExtendableEntities
    {
        $this->entities->push($entity);
        return $this;
    }
    public function prepend(Entity $entity) : ExtendableEntities
    {
        $this->entities->pushAtTheBeginning($entity);
        return $this;
    }
}