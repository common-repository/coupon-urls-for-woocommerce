<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Exceptions\UncreatableDependencyContainerException;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
use Exception;
use function CouponURLs\Original\Utilities\Collection\_;
class DependencyContainerFactory implements ContainerFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependencyInspectorFactory
     */
    protected $dependencyInspectorFactory;
    public function __construct(DependencyInspectorFactory $dependencyInspectorFactory)
    {
        $this->dependencyInspectorFactory = $dependencyInspectorFactory;
    }
    /** @var Dependency
     * @param string|\CouponURLs\Original\Dependency\Dependency $dependency */
    public function create($dependency) : Container
    {
        try {
            return $this->createContainer($dependency);
        } catch (Exception $exception) {
            $this->throwException($dependency);
        }
    }
    /** @var Dependency */
    protected function createContainer(Dependency $dependency) : Container
    {
        (object) ($dependencyContainerFactoryComposite = new DependencyContainerFactoryComposite(new FactoryOverloader(neblabs_collection([new DependentDependencyContainerFactory($this->dependencyInspectorFactory, $this), new CachedInstanceDependencyContainerFactory(), new UnCachedInstanceDependencyContainerFactory()]))));
        return $dependencyContainerFactoryComposite->create($dependency);
    }
    /**
     * @param mixed $dependency
     */
    protected function throwException($dependency) : void
    {
        throw new UncreatableDependencyContainerException(\esc_html("Cannot create Container from dependency: " . (is_object($dependency) ? get_class($dependency) : $dependency) . "\nMake sure the Dependency instance implements Cached or Uncached."));
    }
}