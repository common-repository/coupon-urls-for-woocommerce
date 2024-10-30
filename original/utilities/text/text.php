<?php

namespace CouponURLs\Original\Utilities\Text;

use CouponURLs\Original\Characters\StringManager;
use CouponURLs\Original\Environment\Env;
/**
 * @param string|\CouponURLs\Original\Characters\StringManager|null $string
 */
function i($string) : StringManager
{
    return $string instanceof StringManager ? $string : new StringManager($string ?? '');
}