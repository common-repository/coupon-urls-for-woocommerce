<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Characters\StringManager;
use WP_Post;

interface DashboardExportableForPost extends ExportableForPost
{
    public function key() : string; 
    /**
     * @return mixed[]|\CouponURLs\Original\Characters\StringManager|string|bool|int|float
     */
    public function export(WP_Post $post);
}