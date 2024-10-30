<?php

namespace CouponURLs\Original\Data\Schema;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use CouponURLs\Original\Data\Schema\Abilities\StructureField;
use CouponURLs\Original\Data\Schema\Fields\ID;
use Error;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;
class Fields
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $fields;
    public function __construct(Collection $fields)
    {
        $this->fields = $fields;
        validate(new ItemsAreOnlyInstancesOf($fields, neblabs_collection([StructureField::class])));
        //THROW EXCEPTION FO HAS MORE THEN ONE ID
        //THROW EXCEPTION IF HAS REPEATED KEYS INCLUDING ALIASES
    }
    public function all() : Collection
    {
        return $this->fields;
    }
    public function field(string $name) : StructureField
    {
        return $this->fields->find(function (StructureField $field) use ($name) {
            return $field->is($name);
        });
    }
    public function has(string $fieldName) : bool
    {
        try {
            $this->field($fieldName);
        } catch (Error $exception) {
            return false;
        }
        return true;
    }
    public function hasId() : bool
    {
        return $this->fields->have($this->findableId());
    }
    public function id() : ID
    {
        return $this->fields->find($this->findableId());
    }
    protected function findableId() : callable
    {
        return function (StructureField $field) {
            return $field instanceof ID;
        };
    }
}