<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\HasDependents;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Abilities\Typeable;
use CouponURLs\Original\Collections\SingleItem;

class ComponentWithDependents implements HasDependents
{
    /**
     * @var \CouponURLs\App\Components\Components
     */
    protected $dependents;
    public function __construct(Components $dependents = null)
    {
        $dependents = $dependents ?? new Components();
        $this->dependents = $dependents;
    }
    
    public function dependents(): Components
    {
        return $this->dependents;
    } 

    /**
     * @param \CouponURLs\App\Components\Abilities\Identifiable|\CouponURLs\App\Components\Abilities\Typeable $dependent
     */
    public function addDependent($dependent): void
    {
        $this->dependents->add(new SingleItem($dependent));
    } 
}