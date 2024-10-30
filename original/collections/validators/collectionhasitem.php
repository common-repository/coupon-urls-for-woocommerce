<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Exception;
class CollectionHasItem extends Validator
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $items;
    /**
     * @var mixed
     */
    protected $item;
    /**
     * @var bool
     */
    protected $shouldHaveIt = true;
    /**
     * @param mixed $item
     */
    public function __construct(Collection $items, $item, bool $shouldHaveIt = true)
    {
        $this->items = $items;
        $this->item = $item;
        $this->shouldHaveIt = $shouldHaveIt;
    }
    public function execute() : ValidationResult
    {
        (bool) ($hasItem = $this->items->have(function ($item) {
            return $item === $this->item;
        }));
        return $this->passWhen($this->shouldHaveIt ? $hasItem : !$hasItem);
    }
    protected function getDefaultException() : Exception
    {
        return new ValidationException();
    }
}