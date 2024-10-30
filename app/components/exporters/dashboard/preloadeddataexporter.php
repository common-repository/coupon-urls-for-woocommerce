<?php

namespace CouponURLs\App\Components\Exporters\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Abilities\DashboardExportableForPost;
use CouponURLs\App\Components\Actions\Builtin\AddProductComponent;
use CouponURLs\App\Components\Actions\Builtin\RedirectionComponent;
use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use WP_Post;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;
class PreloadedDataExporter implements DashboardExportableForPost
{
    /**
     * @var \CouponURLs\App\Components\Actions\Builtin\AddProductComponent
     */
    protected $addProductComponent;
    /**
     * @var \CouponURLs\App\Components\Actions\Builtin\RedirectionComponent
     */
    protected $redirectionComponent;
    public function __construct(AddProductComponent $addProductComponent, RedirectionComponent $redirectionComponent)
    {
        $this->addProductComponent = $addProductComponent;
        $this->redirectionComponent = $redirectionComponent;
    }
    public function key() : string
    {
        return 'preloadedItems';
    }
    public function export(WP_Post $post) : array
    {
        $addProductData = get_post_meta($post->ID, Env::getWithPrefix("action_{$this->addProductComponent->identifier()}"), true);
        $redirectProductData = get_post_meta($post->ID, Env::getWithPrefix("action_{$this->redirectionComponent->identifier()}"), true);
        $productId = (($nullsafeVariable1 = i($addProductData ? $addProductData : '{}')->import()) ? $nullsafeVariable1->id : null) ?? 0;
        $redriectionLabel = [];
        if ($redirectProductData) {
            (object) ($options = i($redirectProductData)->import());
            if ((($nullsafeVariable2 = $options) ? $nullsafeVariable2->type : null) === 'postType') {
                $redriectionLabel = ['value' => $options->value, 'label' => ($nullsafeVariable3 = get_post((int) $options->value)) ? $nullsafeVariable3->post_title : null];
            }
        }
        return [$this->addProductComponent->identifier() => $productId ? [['value' => $productId, 'label' => ($nullsafeVariable4 = wc_get_product($productId)) ? $nullsafeVariable4->get_name('edit') : null]] : [], $this->redirectionComponent->identifier() => [$redriectionLabel] ?: []];
    }
}