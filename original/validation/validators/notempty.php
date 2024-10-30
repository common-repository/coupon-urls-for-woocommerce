<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;
class NotEmpty extends Validator
{
    /**
     * @var mixed
     */
    protected $value;
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    public function execute() : ValidationResult
    {
        return $this->passWhen(!empty($this->value));
    }
    protected function getDefaultException() : Exception
    {
        return new Exception(\esc_html("Value: {$this->value} must not be empty."));
    }
}