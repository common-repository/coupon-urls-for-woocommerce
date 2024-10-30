<?php

namespace CouponURLs\Original\Data\Schema\Fields;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Data\Schema\Abilities\StructureField;
use function CouponURLs\Original\Utilities\Text\i;
class Field implements StructureField
{
    /**
     * @var \CouponURLs\Original\Characters\StringManager
     */
    protected $name;
    /**
     * @var \CouponURLs\Original\Characters\StringManager
     */
    protected $alias;
    public function __construct(string $name, string $alias = '')
    {
        $this->name = i($name);
        $this->alias = i($alias);
    }
    public function name() : StringManager
    {
        return $this->name;
    }
    public function is(string $name) : bool
    {
        return $this->name->is($name) || $this->alias->is($name);
    }
}