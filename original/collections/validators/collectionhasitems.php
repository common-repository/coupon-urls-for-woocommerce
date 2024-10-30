<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Exception;
class CollectionHasItems extends Validator
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $collection;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $itemsToCheck;
    /**
     * @var string
     */
    protected $permission;
    /**
     * @var string
     */
    protected $quantifier;
    public function __construct(Collection $collection, Collection $itemsToCheck, string $permission, string $quantifier)
    {
        $this->collection = $collection;
        $this->itemsToCheck = $itemsToCheck;
        $this->permission = $permission;
        $this->quantifier = $quantifier;
    }
    public function execute() : ValidationResult
    {
        switch ($this->quantifier) {
            case 'any':
                $collectionHasThem = $this->collection->containAny($this->itemsToCheck);
                break;
            case 'all':
                $collectionHasThem = $this->collection->containAll($this->itemsToCheck);
                break;
        }
        switch ($this->permission) {
            case 'allowed':
                $matches = $collectionHasThem;
                break;
            case 'forbidden':
                $matches = !$collectionHasThem;
                break;
            default:
                $matches = false;
                break;
        }
        return $this->passWhen($matches);
    }
    protected function getDefaultException() : Exception
    {
        return new ValidationException();
    }
}