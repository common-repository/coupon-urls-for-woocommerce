<?php

namespace CouponURLs\Original\Data\Drivers\Abilities;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Query\Parameters;
interface SingleItemReadableDriver
{
    public function has(Parameters $parameters) : bool;
    /**
     * @return mixed
     */
    public function findOne(Parameters $parameters);
}
//(object) $posts = $postsFinder->withId(87)->find();