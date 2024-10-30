<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Abilities\Methods;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Exceptions\InvalidImplementationException;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\PassingValidationResult;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;
use ReflectionAttribute;
use ReflectionClass;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;
class DuckMethodsAreImplementedCorrectly extends Validator
{
    /**
     * @var string
     */
    protected $interface;
    /**
     * @var string
     */
    protected $implementation;
    /**
     * @var \ReflectionClass
     */
    protected $duckInterfaceReflection;
    /**
     * @var \ReflectionClass
     */
    protected $implementationReflection;
    public function __construct(string $interface, string $implementation)
    {
        $this->interface = $interface;
        $this->implementation = $implementation;
        $this->duckInterfaceReflection = new ReflectionClass($interface);
        $this->implementationReflection = new ReflectionClass($implementation);
    }
    public function execute() : ValidationResult
    {
        //   if (version_compare(PHP_VERSION, '8.0.0', '<')) {
        return new PassingValidationResult();
        // }
        foreach ($this->interfaceMethods()->names() as $methodName) {
            if (!$this->implementationReflection->hasMethod($methodName)) {
                return $this->failed()->withException(new InvalidImplementationException(\esc_html("Missing required method: {$this->implementationReflection->getShortName()}::{$methodName}")));
            }
        }
        return $this->passWhen($this->interfaceMethods()->names()->haveAny());
    }
    protected function interfaceMethods() : Methods
    {
        return neblabs_collection([method_exists($this->duckInterfaceReflection, 'getAttributes') ? $this->duckInterfaceReflection->getAttributes() : []])->find(function (ReflectionAttribute $reflectionAttribute) {
            return i($reflectionAttribute->getName())->toLowerCase()->is(i(Methods::class)->toLowerCase());
        })->newInstance();
    }
    protected function getDefaultException() : Exception
    {
        return new InvalidImplementationException(\esc_html("Class: {$this->implementationReflection->getName()} must correctly implement interface {$this->duckInterfaceReflection->getName()}"));
    }
}