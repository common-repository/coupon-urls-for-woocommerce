<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Dependency\Dependent;
class DependentFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DynamicTypeFactory
     */
    protected $dynamicTypeFactory;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\ContextFactory
     */
    protected $contextFactory;
    public function __construct(DynamicTypeFactory $dynamicTypeFactory, ContextFactory $contextFactory)
    {
        $this->dynamicTypeFactory = $dynamicTypeFactory;
        $this->contextFactory = $contextFactory;
    }
    public function create(string $type) : Dependent
    {
        return new Dependent($this->dynamicTypeFactory->create($type), $this->contextFactory);
    }
}