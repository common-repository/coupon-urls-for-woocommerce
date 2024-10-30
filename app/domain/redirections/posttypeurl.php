<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\URL;
class PostTypeURL implements URL
{
    /**
     * @var int
     */
    protected $postId;
    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }
    public function get() : string
    {
        return get_permalink($this->postId);
    }
}