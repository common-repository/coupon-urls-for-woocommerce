<?php

namespace CouponURLs\Original\Validation\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\{Validator};
use Exception;
class CollectionHasKey extends Validator
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $collection;
    /**
     * @var string
     */
    protected $key;
    public function __construct(Collection $collection, string $key)
    {
        $this->collection = $collection;
        $this->key = $key;
    }
    public function execute() : ValidationResult
    {
        return $this->passWhen($this->collection->hasKey($this->key));
    }
    protected function getDefaultException() : Exception
    {
        return new ValidationException();
    }
}