<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Exceptions\InvalidTypeException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use Exception;
class ItemsHaveObjectTypeOf extends Validator
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $items;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $allowedTypes;
    /**
     * @var string|null
     */
    protected $invalidType;
    public function __construct(Collection $items, Collection $allowedTypes)
    {
        $this->items = $items;
        $this->allowedTypes = $allowedTypes;
    }
    public function execute() : ValidationResult
    {
        return $this->failWhen((bool) ($this->invalidType = $this->items->find(function ($item) {
            return !$this->allowedTypes->have(function (string $fullyQualifiedTypeName) use ($item) {
                return is_a($item, $fullyQualifiedTypeName, true);
            });
        })));
    }
    protected function getDefaultException() : Exception
    {
        throw new InvalidTypeException(\esc_html("Type: {$this->invalidType} must implement: {$this->allowedTypes->implode(' | ')}"));
    }
}