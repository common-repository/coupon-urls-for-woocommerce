<?php

namespace CouponURLs\App\Creation\Actions;

use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;

class OverloadableFactoryById implements OverloadableFactory, FactoryWithVariableArguments
{
    /**
     * @var \CouponURLs\App\Components\Abilities\Identifiable
     */
    protected $identifiable;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\FactoryWithVariableArguments
     */
    protected $factoryWithVariableArguments;
    public function __construct(Identifiable $identifiable, FactoryWithVariableArguments $factoryWithVariableArguments)
    {
        $this->identifiable = $identifiable;
        $this->factoryWithVariableArguments = $factoryWithVariableArguments;
    }
    
    /**
     * @param mixed $value
     */
    public function canCreate($value): bool
    {
        return $value === $this->identifiable->identifier();
    } 

    /**
     * @return mixed
     */
    public function create(...$arguments)
    {
        return $this->factoryWithVariableArguments->create(...$arguments);
    }
}