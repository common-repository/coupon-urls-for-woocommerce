<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;
use function CouponURLs\Original\Utilities\Text\i;
class RelativeURL implements URL
{
    /**
     * @var string
     */
    protected $path;
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    public function get() : string
    {
        return i(get_home_url())->ensureRight($this->path);
    }
}