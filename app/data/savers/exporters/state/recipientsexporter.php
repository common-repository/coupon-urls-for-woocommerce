<?php

namespace CouponURLs\App\Data\Savers\Exporters\State;

use CouponURLs\App\Components\Abilities\DashboardExportableForCoupon;
use CouponURLs\App\Data\Finders\Recipients\RecipientStructure;
use CouponURLs\App\Domain\Posts\Post;
use function CouponURLs\Original\Utilities\Collection\_;
class RecipientsExporter implements DashboardExportableForCoupon
{
    /**
     * @var \CouponURLs\App\Data\Finders\Recipients\RecipientStructure
     */
    protected $recipientStructure;
    public function __construct(RecipientStructure $recipientStructure)
    {
        $this->recipientStructure = $recipientStructure;
    }
    public function key() : string
    {
        return 'recipients';
    }
    public function export(Post $post) : array
    {
        return neblabs_collection([get_post_meta($post->id(), $this->recipientStructure->fields()->id()->id()->get(), false)])->map(function (string $baseRecipinet) {
            return json_decode($baseRecipinet)->email;
        })->asArray();
    }
}