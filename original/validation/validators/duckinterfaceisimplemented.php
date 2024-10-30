<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ClassImplementsInterface;
use Exception;
use ReflectionClass;
class DuckInterfaceIsImplemented extends Validator
{
    /**
     * @var string
     */
    protected $interface;
    /**
     * @var string
     */
    protected $implementation;
    public function __construct(string $interface, string $implementation)
    {
        $this->interface = $interface;
        $this->implementation = $implementation;
    }
    public function execute() : ValidationResult
    {
        return $this->passWhen(new ClassImplementsInterface($this->interface, $this->implementation))->andWhen(new DuckMethodsAreImplementedCorrectly($this->interface, $this->implementation));
    }
    protected function getDefaultException() : Exception
    {
        return new ValidationException();
    }
}