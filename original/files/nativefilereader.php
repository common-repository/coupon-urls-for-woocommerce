<?php

namespace CouponURLs\Original\Files;

use CouponURLs\Original\Abilities\FileReader;
use CouponURLs\Original\Abilities\ReadableFile;
class NativeFileReader implements FileReader
{
    /**
     * @return mixed
     */
    public function read(ReadableFile $readableFile)
    {
        ob_start();
        include $readableFile->source();
        return ob_get_clean();
    }
}