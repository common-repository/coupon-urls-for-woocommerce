<?php

namespace CouponURLs\Original\Data\Model;

use CouponURLs\Original\Data\Instructions\SQLStatementInstruction;
abstract class SQLGateway extends Gateway
{
    protected $table;
    public function insert(Domain $domain)
    {
        $domain->prepareForInsertion();
        return $this->driver->execute(new SQLStatementInstruction("INSERT INTO {$this->table->getName()} ({$this->getFields($domain)}) VALUES({$this->getValuesAsMark($domain)})\n            "), $domain->getAvailableValues());
    }
    public function update(array $data)
    {
        (object) ($data = new Collection($data));
        (string) ($primaryKey = $this->table->getPrimaryKey());
        (object) ($dataToUpdate = $data->only($this->table->getFieldNames())->except([$primaryKey]));
        if (!$data->hasKey($primaryKey)) {
            throw new BadMethodCallException(\esc_html("Please specify the primary key value to limit the update to."));
        }
        if ($dataToUpdate->haveNone()) {
            throw new BadMethodCallException(\esc_html("Please specify the data to update."));
        }
        (string) ($fields = $dataToUpdate->getKeys()->reduce(function ($refValue, StringManager $key) use($dataToUpdate) {
            (string) ($placeHolder = is_null($dataToUpdate->get((string) $key)) ? 'NULL' : '?');
            // we'll make sure only valid registered fields for the table are used
            (string) ($field = $this->table->getField($key->getAlphanumeric()));
            $refValue .= $field ? "{$field} = {$placeHolder}, " : '';
            return $refValue;
        })->trim(', '));
        return $this->driver->execute("UPDATE {$this->table->getName()} SET {$fields} WHERE {$primaryKey} = ? LIMIT 1", $dataToUpdate->except($dataToUpdate->filter('is_null')->getKeys())->resetKeys()->push($data->get($primaryKey))->asArray());
    }
    public function delete(Domain $domain)
    {
        (string) ($primaryKey = $this->table->getPrimaryKey());
        return $this->driver->execute("DELETE FROM {$this->table->getName()} \n             WHERE {$primaryKey} = ? \n             LIMIT 1", [$domain->{$primaryKey}]);
    }
}