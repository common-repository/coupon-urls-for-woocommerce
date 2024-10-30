<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;
class Hooks
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $hooks;
    public function __construct(Collection $hooks)
    {
        $this->hooks = $hooks;
    }
    public function register() : void
    {
        //the old forEvery method is left for the typehinting of 'Hook', will remove when we get generics
        $this->hooks->forEvery(function (Hook $hook) {
            return $hook->register();
        });
    }
    public function unregister() : void
    {
        $this->hooks->perform(['unregister' => null]);
    }
}