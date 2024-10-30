<?php

namespace CouponURLs\App\Domain\URIs;

use CouponURLs\App\Domain\Uris\Abilities\URI;
class HomePageURI extends BaseURI implements URI
{
    public function type() : string
    {
        return 'homepage';
    }
}