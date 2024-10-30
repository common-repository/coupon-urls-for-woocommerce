<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Domain\Posts\Post;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use function CouponURLs\Original\Utilities\Text\i;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
class WordpressPostMetaSaverFromDataProvider extends WordPressPostSaver
{
    /**
     * @var \CouponURLs\App\Data\Savers\WordPressPostMetaSaverDataProvider
     */
    protected $dataProvider;
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $globalFunctionWrapper;
    public function __construct(WordPressPostMetaSaverDataProvider $dataProvider, GlobalFunctionWrapper $globalFunctionWrapper = null)
    {
        $globalFunctionWrapper = $globalFunctionWrapper ?? new GlobalFunctionWrapper();
        $this->dataProvider = $dataProvider;
        $this->globalFunctionWrapper = $globalFunctionWrapper;
    }
    public function setPost(Post $post) : void
    {
        parent::setPost($post);
        $this->dataProvider->setPost($post);
    }
    public function canBeSaved(Collection $data) : \CouponURLs\Original\Validation\Validator
    {
        return new Validators([new ValidWhen($data->valueIsNotNull($this->dataProvider->inputKey())), new ValidWhen(function () use ($data) {
            return $this->dataProvider->canBeSaved(i($data->get($this->dataProvider->inputKey())))->isValid();
        })]);
    }
    public function save(Collection $data)
    {
        /*string|Collection*/
        $itemsToSave = $this->dataProvider->dataToSave(i($data->get($this->dataProvider->inputKey())));
        #We're not using update_post_meta for when a provider has several values
        delete_post_meta($this->post->id(), $this->dataProvider->outputKey());
        foreach (neblabs_collection([$itemsToSave]) as $dataToSave) {
            add_post_meta($this->post->id(), $this->dataProvider->outputKey(), $dataToSave, false);
        }
    }
}