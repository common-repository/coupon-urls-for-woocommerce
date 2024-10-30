<?php

namespace CouponURLs\App\Components\Abilities;

use WP_Post;

interface ExportableForPost
{
    /**
     * @return mixed
     */
    public function export(WP_Post $post); 
}