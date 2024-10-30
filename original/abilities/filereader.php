<?php

namespace CouponURLs\Original\Abilities;

interface FileReader
{
    /**
     * @return mixed
     */
    public function read(ReadableFile $readableFile);
}