<?php

namespace CouponURLs\Original\Validation;

class PassingValidationResult extends ValidationResult
{
    // we don't care, we're passing so we don't have to validate the other results
    /**
     * @return $this
     */
    public function orWhenBoolean(bool $isValid) : \CouponURLs\Original\Validation\ValidationResult
    {
        return $this;
    }
    // we don't care, we're passing so we don't have to validate the other results
    /**
     * @return $this
     */
    public function orWhenValidator(Validator $validator) : \CouponURLs\Original\Validation\ValidationResult
    {
        return $this;
    }
    public function andWhenBoolean(bool $isValid) : ValidationResult
    {
        if ($isValid) {
            return $this;
        }
        return new FailingValidationResult();
    }
    // we don't care, we're passing so we don't have to validate the other results
    public function andWhenValidator(Validator $validator) : ValidationResult
    {
        return $this->andWhenBoolean($validator->isValid())->withException($validator->getException());
    }
    public function isFailing() : bool
    {
        return false;
    }
}