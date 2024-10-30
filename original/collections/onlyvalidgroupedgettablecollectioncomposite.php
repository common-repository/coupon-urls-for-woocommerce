<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\Abilities\ValidatableGettableCollection;
use function CouponURLs\Original\Utilities\Collection\_;
class OnlyValidGroupedGettableCollectionComposite implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $validatableGettableCollections;
    public function __construct(Collection $validatableGettableCollections)
    {
        $this->validatableGettableCollections = $validatableGettableCollections;
    }
    public function get() : Collection
    {
        (object) ($validGettableCollections = $this->validatableGettableCollections->getThoseThat(['canBeUsed' => null]));
        return $validGettableCollections->reduce(function (Collection $collections, GettableCollection $gettableCollection) {
            return $collections->append($gettableCollection->get()->ungroup());
        }, neblabs_collection([]))->group();
    }
}