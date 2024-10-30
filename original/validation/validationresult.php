<?php

namespace CouponURLs\Original\Validation;

use CouponURLs\Original\Validation\Exceptions\ValidationException;
use Exception;
abstract class ValidationResult
{
    protected $defaultException;
    protected $exception;
    public abstract function isFailing() : bool;
    public abstract function orWhenBoolean(bool $isValid) : ValidationResult;
    public abstract function orWhenValidator(Validator $validator) : ValidationResult;
    public abstract function andWhenBoolean(bool $isValid) : ValidationResult;
    public abstract function andWhenValidator(Validator $validator) : ValidationResult;
    public function __construct(Exception $exception = null)
    {
        $this->defaultException = new ValidationException(\esc_html('Validation Failed!'));
        $this->exception = $exception ?? $this->defaultException;
    }
    /**
     * @param bool|\CouponURLs\Original\Validation\Validator $booleanOrValidator
     */
    public function orWhen($booleanOrValidator) : ValidationResult
    {
        if (is_bool($booleanOrValidator)) {
            return $this->orWhenBoolean($booleanOrValidator);
        }
        return $this->orWhenValidator($booleanOrValidator);
    }
    /**
     * @param bool|\CouponURLs\Original\Validation\Validator $booleanOrValidator
     */
    public function andWhen($booleanOrValidator) : ValidationResult
    {
        if (is_bool($booleanOrValidator)) {
            return $this->andWhenBoolean($booleanOrValidator);
        }
        return $this->andWhenValidator($booleanOrValidator);
    }
    public function withException(Exception $exception) : ValidationResult
    {
        $this->exception = $exception;
        return $this;
    }
    public function getException() : Exception
    {
        return $this->exception;
    }
    public function setExceptionWhenNoCustomExceptionHasBeenSet(Exception $exception) : ValidationResult
    {
        if ($this->hasDefaultException()) {
            return $this->withException($exception);
        }
        return $this;
    }
    protected function hasDefaultException() : bool
    {
        return $this->defaultException === $this->exception;
    }
}