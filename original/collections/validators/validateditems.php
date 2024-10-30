<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;
class ValidatedItems extends Validator implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $items;
    /**
     * @var \CouponURLs\Original\Validation\Validator
     */
    protected $validator;
    public function __construct(Collection $items, Validator $validator)
    {
        $this->items = $items;
        $this->validator = $validator;
    }
    public function get() : Collection
    {
        $this->validator->validate();
        return $this->items;
    }
    public function execute() : ValidationResult
    {
        return $this->passWhen($this->validator->isValid());
    }
    protected function getDefaultException() : Exception
    {
        return $this->validator->getException();
    }
}