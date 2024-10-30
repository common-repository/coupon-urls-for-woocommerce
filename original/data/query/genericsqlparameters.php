<?php

namespace CouponURLs\Original\Data\Query;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Schema\Fields\ID;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;
class GenericSQLParameters extends Parameters
{
    /**
     * @var \CouponURLs\Original\Characters\StringManager
     */
    protected $queryString;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $queryValues;
    public function setInternalRelationship(ID $idField) : void
    {
        // todo:
    }
    public function reset() : void
    {
        $this->queryString = i('');
        $this->queryValues = neblabs_collection([]);
        $this->appendSQL("SELECT * FROM " . sanitize_text_field($this->structure->name()));
    }
    public function query() : string
    {
        return $this->queryString->get();
    }
    public function appendSQL(string $sql, array $values = [])
    {
        $this->queryString = $this->queryString->append($sql);
        $this->queryValues = $this->queryValues->concat($values);
    }
    public function queryString() : StringManager
    {
        return $this->queryString;
    }
    public function queryValues() : Collection
    {
        return $this->queryValues;
    }
}