<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\App\Data\Savers\Abilities\Saveable;
use CouponURLs\Original\Collections\Collection;
class SaverComposite implements Saveable
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $saveables;
    public function __construct(Collection $saveables)
    {
        $this->saveables = $saveables;
    }
    /**
     * @param mixed $data
     */
    public function save($data)
    {
        $this->saveables->perform(['save' => $data]);
    }
}