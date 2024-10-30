<?php

namespace CouponURLs\Original\Domain;

use CouponURLs\Original\Collections\Collection;
abstract class Entities
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $entities;
    protected abstract function getDomainClass() : string;
    /**
     * @param \CouponURLs\Original\Collections\Collection|mixed[] $entities
     */
    public function __construct($entities)
    {
        $this->setEntities($entities);
    }
    /**
     * @param \CouponURLs\Original\Collections\Collection|mixed[] $entities
     */
    protected function setEntities($entities) : void
    {
        $entities = new Collection($entities);
        $this->throwExceptionIfItDoesNotContainDomainType($entities);
        $this->entities = $entities;
    }
    public function asCollection() : Collection
    {
        return clone $this->entities;
    }
    protected function throwExceptionIfItDoesNotContainDomainType(Collection $items)
    {
        (bool) ($hasItemsThatAreNotOfTheType = $items->have(function ($item) : bool {
            (string) ($domainClass = $this->getDomainClass());
            return !$item instanceof $domainClass;
        }));
        if ($hasItemsThatAreNotOfTheType) {
            throw new \UnexpectedValueException(\esc_html("Collection can only contain instances of {$this->getDomainClass()}"));
        }
    }
}