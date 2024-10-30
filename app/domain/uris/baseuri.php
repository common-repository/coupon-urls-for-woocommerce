<?php

namespace CouponURLs\App\Domain\URIs;

use CouponURLs\App\Domain\Uris\QueryParameters;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Domain\Entity;
abstract class BaseURI extends Entity implements URI
{
    /**
     * @var \CouponURLs\App\Domain\Uris\QueryParameters
     */
    protected $queryParameters;
    protected $value = '';
    public function __construct(QueryParameters $queryParameters, $value = '')
    {
        $this->queryParameters = $queryParameters;
        $this->value = $value;
    }
    /**
     * @return string|int
     */
    public function value()
    {
        return $this->value;
    }
    public function queryParameters() : QueryParameters
    {
        return $this->queryParameters;
    }
}