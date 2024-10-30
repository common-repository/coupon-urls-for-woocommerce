<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Closure;
use Exception;
class ValidWhen extends Validator
{
    /**
     * @var bool|\Closure
     */
    protected $value;
    /**
     * @param bool|\Closure $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    public function execute() : ValidationResult
    {
        (bool) ($value = is_callable($this->value) ? ($this->value)() : $this->value);
        return $this->passWhen($value === true);
    }
    protected function getDefaultException() : Exception
    {
        return new ValidationException();
    }
}