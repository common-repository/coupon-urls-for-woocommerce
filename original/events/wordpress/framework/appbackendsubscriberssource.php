<?php

namespace CouponURLs\Original\Events\Wordpress\Framework;

use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Environment\Env;
class AppBackendSubscribersSource implements ReadableFile
{
    public function source() : string
    {
        return Env::appDirectory() . 'events/actions/backend.php';
    }
}