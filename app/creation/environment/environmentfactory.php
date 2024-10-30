<?php

namespace CouponURLs\App\Creation\Environment;

use CouponURLs\Original\Environment\Abilities\Environment;
use CouponURLs\Original\Environment\Development;
use CouponURLs\Original\Environment\Production;

class EnvironmentFactory
{
    public function create(string $environment) : Environment
    {
        switch ($environment) {
            case 'development':
                return new Development;
            default:
                return new Production;
        }
    }
}