<?php

namespace CouponURLs\Original\Data\Query;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Schema\Fields\ID;
use CouponURLs\Original\Data\Schema\Structure;
use Exception;
use function CouponURLs\Original\Utilities\Collection\_;
abstract class Parameters
{
    /**
     * @var \CouponURLs\Original\Data\Schema\Structure
     */
    protected $structure;
    /**
     * @return mixed
     */
    public abstract function query();
    public abstract function setInternalRelationship(ID $idField) : void;
    public abstract function reset() : void;
    public function __construct(Structure $structure)
    {
        $this->structure = $structure;
        $this->reset();
    }
    public function beforePassingToDriver() : void
    {
        if ($this->structure->fields()->hasId()) {
            $this->setInternalRelationship($this->structure->fields()->id());
        }
    }
    public function structure() : Structure
    {
        return $this->structure;
    }
}