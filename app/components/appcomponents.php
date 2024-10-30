<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\ComponentsRegistrator;
use CouponURLs\App\Components\Abilities\MultipleComponentsProvider;
use CouponURLs\Original\Collections\Collection;
class AppComponents
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $componentRegistrators;
    public function __construct(Collection $componentRegistrators = null)
    {
        $componentRegistrators = $componentRegistrators ?? new Collection([]);
        $this->componentRegistrators = $componentRegistrators;
    }
    public function addRegistrator(ComponentsRegistrator $componentsRegistrator) : void
    {
        $this->componentRegistrators->push($componentsRegistrator);
    }
    public function registrator(string $id) : ComponentsRegistrator
    {
        return $this->componentRegistrators->find(function (ComponentsRegistrator $componentsRegistrator) use ($id) {
            return $componentsRegistrator->id()->is($id);
        });
    }
    public function register(MultipleComponentsProvider $multipleComponentsProvider) : void
    {
        (object) ($compatibleComponentRegistrators = $this->componentRegistrators->getThoseThat(['canRegisterUsing' => $multipleComponentsProvider]));
        $compatibleComponentRegistrators->perform(['registerUsing' => $multipleComponentsProvider]);
    }
}