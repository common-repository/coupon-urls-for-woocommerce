<?php

namespace CouponURLs\Original\Data\Query;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Collections\Collection;
use AllowDynamicProperties;
use CouponURLs\Original\Data\Schema\Fields\ID;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
class WordPressPostQueryParameters extends Parameters
{
    public const NO_LIMIT = -1;
    /**
     * @var int
     */
    protected $posts_per_page = self::NO_LIMIT;
    public function setInternalRelationship(ID $idField) : void
    {
        $this->setPostType($idField->id());
    }
    public function reset() : void
    {
        foreach ($this->argumentKeysFromProperties() as $property) {
            unset($this->{$property});
        }
        $this->setLimitTo(static::NO_LIMIT);
    }
    public function query() : Collection
    {
        return $this->argumentKeysFromProperties()->mapWithKeys(function (StringManager $property) {
            return ['key' => $property->get(), 'value' => is_object($this->{$property}) ? (string) $this->{$property} : $this->{$property}];
        });
    }
    public function setLimitTo(int $maximumNumberOfPosts) : WordPressPostQueryParameters
    {
        $this->posts_per_page = $maximumNumberOfPosts;
        return $this;
    }
    public function setPostType(string $postType) : WordPressPostQueryParameters
    {
        $this->post_type = neblabs_collection([$postType])->filter()->asArray();
        return $this;
    }
    public function setPostStatus(string $postStatus) : WordPressPostQueryParameters
    {
        $this->post_status = neblabs_collection([$postStatus])->filter()->asArray();
        return $this;
    }
    /**
     * @param mixed $value
     */
    public function setMetaValue($value) : WordPressPostQueryParameters
    {
        $this->meta_value = $value;
        return $this;
    }
    /**
     * @return mixed
     */
    public function metaValue()
    {
        return $this->meta_value;
    }
    protected function argumentKeysFromProperties() : Collection
    {
        return neblabs_collection([get_object_vars($this)])->except(['structure'])->getKeys();
    }
    protected function addToMetaQuery(array $metaQueryParameters) : void
    {
        if (!isset($this->meta_query)) {
            $this->meta_query = [];
        }
        $this->meta_query[] = $metaQueryParameters;
    }
}