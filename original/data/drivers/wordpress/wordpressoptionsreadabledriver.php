<?php

namespace CouponURLs\Original\Data\Drivers\Wordpress;

use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;
class WordPressOptionsReadableDriver implements ReadableDriver
{
    public function has(Parameters $parameters) : bool
    {
        (string) ($placeholderForNonExistingOption = '__NULL__');
        return get_option($parameters->find()) !== $placeholderForNonExistingOption;
    }
    /**
     * @return mixed
     */
    public function find(Parameters $parameters)
    {
        return get_option($parameters->get());
    }
}