<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;

class PlainURL implements URL
{
    /**
     * @var string
     */
    protected $url;
    public function __construct(string $url)
    {
        $this->url = $url;
    }
    
    public function get(): string
    {
        return $this->url;
    } 
}