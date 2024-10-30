<?php

namespace CouponURLs\Original\Collections;

use CouponURLs\Original\Abilities\FileReader;
use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Abilities\ReadableFile;
use CouponURLs\Original\Files\RequireFileReader;
use CouponURLs\Original\Files\RequireOnceFileReader;
use function CouponURLs\Original\Utilities\Collection\_;
class ByFileGettableCollection implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Abilities\ReadableFile
     */
    protected $registeredItemsFile;
    /**
     * @var \CouponURLs\Original\Abilities\FileReader
     */
    protected $fileReader;
    public function __construct(ReadableFile $registeredItemsFile, FileReader $fileReader = null)
    {
        $fileReader = $fileReader ?? new RequireFileReader();
        $this->registeredItemsFile = $registeredItemsFile;
        $this->fileReader = $fileReader;
    }
    public function get() : Collection
    {
        return neblabs_collection([$this->fileReader->read($this->registeredItemsFile)]);
    }
}