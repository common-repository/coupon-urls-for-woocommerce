<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Cache\Cache;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Dependency\Abilities\DynamicType;
use CouponURLs\Original\Dependency\Abilities\Context;
use ReflectionClass;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
class Dependent implements Dependency, DynamicType
{
    /**
     * @var \CouponURLs\Original\Dependency\Abilities\DynamicType
     */
    protected $dynamicType;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\ContextFactory
     */
    protected $contextFactory;
    /**
     * @var \CouponURLs\Original\Cache\Cache
     */
    protected $cache;
    /**
     * @var \CouponURLs\Original\Dependency\DependenciesContainer
     */
    protected $dependenciesContainer;
    public function __construct(DynamicType $dynamicType, ContextFactory $contextFactory, Cache $cache = null)
    {
        $cache = $cache ?? new MemoryCache();
        $this->dynamicType = $dynamicType;
        $this->contextFactory = $contextFactory;
        $this->cache = $cache;
    }
    public function type() : string
    {
        return $this->dynamicType->type();
    }
    public function defaultType() : string
    {
        return $this->dynamicType->defaultType();
    }
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void
    {
        $this->dependenciesContainer = $dependenciesContainer;
    }
    public function canBeCreated(Context $context) : bool
    {
        return class_exists($this->dynamicType->type()) && $this->parametersAreAllTyped();
    }
    public function parametersAreAllTyped() : bool
    {
        (object) ($dependencyTypes = $this->dependencyTypesAndContexts());
        (object) ($nonTypedArgument = function (Collection $dependencyTypeAndContext) {
            return !(is_string($dependencyTypeAndContext->get('type')) && (class_exists($dependencyTypeAndContext->get('type')) || interface_exists($dependencyTypeAndContext->get('type'))));
        });
        return $dependencyTypes->haveNone() || $dependencyTypes->doesNotHave($nonTypedArgument);
    }
    public function create() : object
    {
        (string) ($defaultType = $this->dynamicType->defaultType());
        return new $defaultType(...$this->dependencies()->asArray());
    }
    protected function dependencies() : Collection
    {
        return $this->dependencyTypesAndContexts()->map(function (Collection $dependencyTypeAndContext) {
            return $this->dependenciesContainer->get($dependencyTypeAndContext->get('type'), $dependencyTypeAndContext->get('context'));
        });
    }
    protected function dependencyTypesAndContexts() : Collection
    {
        (string) ($type = $this->dynamicType->defaultType());
        $reflectionClass = new ReflectionClass($type);
        $constructor = $reflectionClass->getConstructor();
        return $this->cache->getIfExists($type)->otherwise(function () use($type) {
            $reflectionClass = new ReflectionClass($type);
            $constructor = $reflectionClass->getConstructor();
            return neblabs_collection([(($nullsafeVariable1 = $constructor) ? $nullsafeVariable1->getParameters() : null) ?? []])->map(function ($parameter) {
                return neblabs_collection(['type' => (string) $parameter->getType(), 'context' => $this->contextFactory->create($parameter)]);
            });
        });
    }
}