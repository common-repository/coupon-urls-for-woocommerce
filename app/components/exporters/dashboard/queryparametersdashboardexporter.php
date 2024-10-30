<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Environment\Env;
use WP_Post;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;
class QueryParametersDashboardExporter implements DashboardExportableForPost
{
    /**
     * @var \CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory
     */
    protected $queryParametersFromStringFactory;
    public function __construct(QueryParametersFromStringFactory $queryParametersFromStringFactory)
    {
        $this->queryParametersFromStringFactory = $queryParametersFromStringFactory;
    }
    public function key() : string
    {
        return 'queryParameters';
    }
    public function export(WP_Post $post) : array
    {
        return $this->queryParametersFromStringFactory->create(get_post_meta($post->ID, Env::getWithPrefix('query'), true) ?: '')->all()->map(function ($value, string $key) {
            return ['key' => $key, 'value' => $value];
        })->getValues()->asArray();
    }
}