<?php

namespace CouponURLs\Original\Data\Model;

use CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters;
use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;
abstract class Finder
{
    /**
     * @var \CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver
     */
    protected $readableDriver;
    /**
     * @var \CouponURLs\Original\Data\Query\Parameters
     */
    protected $parameters;
    /**
     * @var \CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters
     */
    protected $entityFactory;
    public function __construct(ReadableDriver $readableDriver, Parameters $parameters, CreatableEntitiesWithParameters $entityFactory)
    {
        $this->readableDriver = $readableDriver;
        $this->parameters = $parameters;
        $this->entityFactory = $entityFactory;
    }
    public function findIt() : Entity
    {
        $this->parameters->beforePassingToDriver();
        (object) ($rawEntity = $this->readableDriver->findOne($this->parameters));
        (object) ($entity = $this->entityFactory->createEntity($rawEntity, $this->parameters));
        $this->parameters->reset();
        return $entity;
    }
    public function findThem() : Entities
    {
        $this->parameters->beforePassingToDriver();
        (object) ($rawEntities = $this->readableDriver->findMany($this->parameters));
        (object) ($entities = $this->entityFactory->createEntities($rawEntities, $this->parameters));
        $this->parameters->reset();
        return $entities;
    }
    public function count() : int
    {
        return $this->readableDriver->count($this->parameters);
    }
    public function has() : bool
    {
        return $this->readableDriver->has($this->parameters);
    }
}