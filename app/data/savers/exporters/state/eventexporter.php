<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Data\Finders\Events\EventStructure;
use CouponURLs\App\Domain\Posts\Post;

class EventExporter implements DashboardExportableForCoupon
{
    /**
     * @var \CouponURLs\App\Data\Finders\Events\EventStructure
     */
    protected $eventStructure;
    public function __construct(EventStructure $eventStructure)
    {
        $this->eventStructure = $eventStructure;
    }
    
    public function key(): string
    {
        return 'event';
    } 

    public function export(Post $post): string
    {
        return get_post_meta(
            $post->id(),
            $this->eventStructure->fields()->id()->id()->get(),
            true
        );
    } 
}