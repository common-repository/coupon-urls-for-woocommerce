<?php

namespace CouponURLs\Original\Files;

use CouponURLs\Original\Abilities\ReadableFile;
class InlineReadableFile implements ReadableFile
{
    /**
     * @var string
     */
    protected $filePath;
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }
    public function source() : string
    {
        return $this->filePath;
    }
}