<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\App\Data\Finders\Conditions\ConditionsFinder;
use CouponURLs\App\Data\Finders\Conditions\ConditionsStructure;
use CouponURLs\Original\Data\Drivers\SQL\WordPressDatabaseReadableDriver;
use CouponURLs\Original\Data\Query\SQLParameters;
class ConditionsFinderDependency implements Dependency
{
    /**
     * @var \CouponURLs\Original\Data\Drivers\SQL\WordPressDatabaseReadableDriver
     */
    protected $wordPressDatabaseReadableDriver;
    /**
     * @var \CouponURLs\App\Data\Finders\Conditions\ConditionsStructure
     */
    protected $conditionsStructure;
    /**
     * @var \CouponURLs\Original\Dependency\ConditionsFactory
     */
    protected $conditionsFactory;
    public function __construct(WordPressDatabaseReadableDriver $wordPressDatabaseReadableDriver, ConditionsStructure $conditionsStructure, ConditionsFactory $conditionsFactory)
    {
        $this->wordPressDatabaseReadableDriver = $wordPressDatabaseReadableDriver;
        $this->conditionsStructure = $conditionsStructure;
        $this->conditionsFactory = $conditionsFactory;
    }
    public function canBeUsed(Context $context, Environment $environment) : bool
    {
        return $environment->isProduction;
    }
    public function create() : object
    {
        return new ConditionsFinder($this->wordPressDatabaseReadableDriver, new SQLParameters($this->conditionsStructure), $this->conditionsFactory);
    }
}