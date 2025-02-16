<?php

namespace CouponURLs\Original\Core\Services;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Collections\ByFileGettableCollection;
use CouponURLs\Original\Core\Abilities\Service;
use CouponURLs\Original\Core\Abilities\ServicesContainer;
class AppServices implements Service
{
    /**
     * @var \CouponURLs\Original\Abilities\GettableCollection
     */
    protected $registeredAppServices;
    public function __construct(GettableCollection $registeredAppServices)
    {
        $this->registeredAppServices = $registeredAppServices;
    }
    public function id() : string
    {
        return 'app-services';
    }
    public function start(ServicesContainer $servicesContainer) : void
    {
        (object) ($appServices = $this->registeredAppServices->get());
        $appServices->forEvery(\Closure::fromCallable([$servicesContainer, 'addService']));
    }
    public function stop(ServicesContainer $servicesContainer) : void
    {
    }
}