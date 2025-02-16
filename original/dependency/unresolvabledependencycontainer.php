<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Dependency\Exceptions\UnresolvableDependencyException;
class UnresolvableDependencyContainer implements Container
{
    /**
     * @var \CouponURLs\Original\Dependency\DependenciesContainer
     */
    protected $dependenciesContainer;
    /**
     * @var \CouponURLs\Original\Dependency\Abilities\Context
     */
    protected $context;
    public function matches(string $type, Context $context) : bool
    {
        $this->context = $context;
        return true;
    }
    public function get(string $type) : object
    {
        throw new UnresolvableDependencyException(\esc_html("Could not resolve dependency: {$type}." . PHP_EOL . "---------------------------------------------" . PHP_EOL . "From Context:" . PHP_EOL . $this->renderContext($this->context) . "---------------------------------------------" . PHP_EOL . "Dependency stack: {$this->renderDependencyStack()}"));
    }
    protected function renderContext(?Context $context) : string
    {
        return ($context instanceof KnownContext ? "\tClass: {$context->fullyQualifiedTypeName()}" . PHP_EOL . "\tMethod: {$context->methodName()}" . PHP_EOL . "\tProperty Name: \${$context->name()}" . PHP_EOL : "\tUnkown Context") . PHP_EOL;
    }
    protected function renderDependencyStack() : string
    {
        return $this->dependenciesContainer->currentDependencyStack()->map(function (array $typeAndContext) : string {
            return "{$typeAndContext['type']}: \n{$this->renderContext($typeAndContext['context'])}";
        })->implode("\n\n -> ");
    }
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void
    {
        $this->dependenciesContainer = $dependenciesContainer;
    }
}