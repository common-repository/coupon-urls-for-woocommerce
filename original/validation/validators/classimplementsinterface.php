<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;
use ReflectionClass;
class ClassImplementsInterface extends Validator
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
    protected $implementationReflection;
    public function __construct(string $interface, string $implementation)
    {
        $this->interface = $interface;
        $this->implementation = $implementation;
        $this->implementationReflection = new ReflectionClass($implementation);
    }
    public function execute() : ValidationResult
    {
        return $this->passWhen($this->implementationReflection->implementsInterface($this->interface));
    }
    protected function getDefaultException() : Exception
    {
        return new ValidationException();
    }
}