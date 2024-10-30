<?php

namespace CouponURLs\Original\Collections\Validators;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Exceptions\InvalidTypeException;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Exceptions\ValidationException;
use CouponURLs\Original\Validation\Validator;
use Exception;
class ItemsAreOnlyInstancesOf extends Validator
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
     * @var mixed
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
                return $item instanceof $fullyQualifiedTypeName;
            });
        })));
    }
    protected function getDefaultException() : Exception
    {
        throw new InvalidTypeException(\esc_html("Type: {$this->invalidReadableType()} must implement: {$this->allowedTypes->implode(' | ')}"));
    }
    protected function invalidReadableType() : string
    {
        switch ($nativeType = gettype($this->invalidType)) {
            case 'object':
                return get_class($this->invalidType);
            default:
                return $nativeType;
        }
    }
}