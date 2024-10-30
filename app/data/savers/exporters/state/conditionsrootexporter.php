<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Data\Finders\ConditionsRoot\ConditionsRootStructure;
use CouponURLs\App\Domain\Posts\Post;
use function CouponURLs\Original\Utilities\Collection\_;
class ConditionsRootExporter implements DashboardExportableForCoupon
{
    /**
     * @var \CouponURLs\App\Data\Finders\ConditionsRoot\ConditionsRootStructure
     */
    protected $conditionsRootStructure;
    public function __construct(ConditionsRootStructure $conditionsRootStructure)
    {
        $this->conditionsRootStructure = $conditionsRootStructure;
    }
    public function key() : string
    {
        return 'conditionsRoot';
    }
    public function export(Post $post) : string
    {
        (string) ($conditionsRootSource = get_post_meta($post->id(), $this->conditionsRootStructure->fields()->id()->id()->get(), true));
        if (is_object(json_decode($conditionsRootSource))) {
            return $conditionsRootSource;
        }
        return neblabs_collection(['type' => 'none', 'subjectConditions' => []])->asJson();
    }
}