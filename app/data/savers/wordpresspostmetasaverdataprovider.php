<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Data\Savers\Abilities\KeyValueSaveableDataProvider;
use CouponURLs\App\Domain\Posts\Post;

abstract class WordPressPostMetaSaverDataProvider implements KeyValueSaveableDataProvider
{
    /**
     * @var \CouponURLs\App\Domain\Posts\Post
     */
    protected $post;

    public function setPost(Post $post) 
    {
        $this->post = $post;
    }
}