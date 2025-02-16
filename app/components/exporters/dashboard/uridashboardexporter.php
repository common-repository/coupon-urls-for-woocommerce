<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use WP_Post;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;
class URIDashboardExporter implements DashboardExportableForPost
{
    public function key() : string
    {
        return 'uri';
    }
    public function export(WP_Post $post) : array
    {
        /** @var Collection */
        (object) ($uri = i(get_post_meta($post->ID, Env::getWithPrefix('uri'), true) ?: '')->explode('|')->getValues() ?: neblabs_collection(['', '']));
        return ['type' => $uri->first(), 'value' => $uri->haveExactly(1) ? '' : $uri->last()];
    }
}