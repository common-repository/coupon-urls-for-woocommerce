<?php

namespace CouponURLs\App\Domain\Uris;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
class QueryParameters
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $parameters;
    public function __construct(Collection $parameters)
    {
        $this->parameters = $parameters;
        $this->parameters = $parameters->map(function ($value) {
            return $value instanceof StringManager ? $value->get() : $value;
        });
    }
    /**
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->parameters->get($key);
    }
    public function has(string $key) : bool
    {
        return $this->parameters->have($key);
    }
    public function all() : Collection
    {
        return clone $this->parameters;
    }
    /**
     * $queryParameters should have ALL parameters
     * $this CAN have more and still match, as long as it has 
     * all of $queryParameters
     */
    public function hasAllOf(QueryParameters $queryParameters) : bool
    {
        return $queryParameters->parameters->doesNotHave(function ($value, string $key) {
            return $this->get($key) !== $value;
        });
    }
}