<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\Dependent;
use CouponURLs\App\Components\Abilities\Descriptable;
use CouponURLs\App\Components\Abilities\HasDependents;
use CouponURLs\App\Components\Abilities\HasTemplateOptions;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Nameable;
use CouponURLs\App\Components\Abilities\Typeable;
use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Collections\Collection;
use PHPUnit\TestRunner\TestResult\Collector;

use function CouponURLs\Original\Utilities\Collection\_;

class Components
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $registeredComponents;
    /**
     * @var \CouponURLs\Original\Cache\MemoryCache
     */
    protected $cache;
    public function __construct(Collection $registeredComponents = null, MemoryCache $cache = null)
    {
        $registeredComponents = $registeredComponents ?? new Collection([]);
        $cache = $cache ?? new MemoryCache;
        $this->registeredComponents = $registeredComponents;
        $this->cache = $cache;
    }

    public function add(GettableCollection $components) : void
    {
        $this->registeredComponents->append($components->get());
    }

    /**
     * @return \CouponURLs\App\Components\Abilities\Identifiable|\CouponURLs\App\Components\Abilities\Typeable|\CouponURLs\App\Components\Abilities\Nameable|\CouponURLs\App\Components\Abilities\Descriptable|\CouponURLs\App\Components\Abilities\HasTemplateOptions
     */
    public function withId(string $id)
    {
        return $this->registeredComponents->find($this->id($id));
    }

    public function has(string $id) : bool
    {
        return $this->registeredComponents->have($this->id($id));
    }

    protected function id(string $id) : callable
    {
        return function (Identifiable $component) use ($id) {
            return $component->identifier() === $id;
        };
    }

    public function baseOnly() : self
    {
        // we need to cache it because we only want to add the templates to the parent once.
        // if this method is called twice in the same request, it'd add the same templates every time
        return $this->cache->getIfExists('baseComponents')->otherwise(function () {
            return new static(
                $this->registeredComponents->filter(
                    function (Identifiable $identifiable) {
                        return !$identifiable instanceof Dependent;
                    }
                )->map(function($baseComponent) {
                    if ($baseComponent instanceof HasDependents) {
                        $this->registeredComponents->filter(
                            function ($component) {
                                return $component instanceof Dependent;
                            }
                        )->filter(
                            function (Dependent $dependent) use ($baseComponent) {
                                return $dependent->dependsOn() === $baseComponent->identifier();
                            }
                        )->forEvery(
                            function ($dependent) use ($baseComponent) {
                                return $baseComponent->addDependent($dependent);
                            }
                        );
                    }

                    return $baseComponent;
                })->getValues()
            );
        });
    }

    public function all() : Collection
    {
        return clone $this->registeredComponents;
    }

    //methods for getting all typeable (for those wuith an implementetion)
    //all nebalme, etc
}