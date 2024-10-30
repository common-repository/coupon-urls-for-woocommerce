<?php

namespace CouponURLs\App\Domain\Uris\Abilities;

use CouponURLs\App\Domain\Uris\QueryParameters;
interface URI
{
    public function type() : string;
    /**
     * @return string|int
     */
    public function value();
    public function queryParameters() : QueryParameters;
}