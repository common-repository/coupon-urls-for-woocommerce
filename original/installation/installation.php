<?php

namespace CouponURLs\Original\Installation;

use CouponURLs\App\Installators\ConcreteInstallator;
use CouponURLs\Original\Environment\Env;
abstract class Installation
{
    /**
     * Runs only once after it's been installed and activated.
     * Runs before static::activate();
     */
    public abstract function install();
    public abstract function activate();
    public abstract function deactivate();
    public function __construct()
    {
        $this->registerInstallation();
        $this->registerActivation();
        $this->registerDeactivation();
    }
    protected function registerInstallation()
    {
        (object) ($installEvent = new InstallEvent($this));
        $installEvent->runOnce();
    }
    protected function registerActivation()
    {
        register_activation_hook(Env::absolutePluginFilePath(), [$this, 'activate']);
    }
    protected function registerDeactivation()
    {
        register_deactivation_hook(Env::absolutePluginFilePath(), [$this, 'deactivate']);
    }
}