<?php

namespace CouponURLs\App\Dependencies;

use CouponURLs\App\Creation\Actions\ActionsFactory;
use CouponURLs\App\Creation\Coupons\CouponFactory;
use CouponURLs\App\Creation\Coupons\CouponOptionsFromCouponFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\CouponURLsFromCouponIdFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\QueryParametersFromStringMatchingCurrentRequestFactory;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Data\Finders\Couponurls\CouponURLsFinder;
use CouponURLs\App\Data\Schema\PostMetaStructure;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Data\Drivers\SQL\WordPressDatabaseReadableDriver;
use CouponURLs\Original\Data\Query\GenericSQLParameters;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
use WC_Discounts;

class CouponURLsFinderDependency implements Cached, StaticType, Dependency
{
    /**
     * @var \CouponURLs\Original\Data\Drivers\SQL\WordPressDatabaseReadableDriver
     */
    protected $readableDriver;
    /**
     * @var \WC_Discounts
     */
    protected $discounts;
    /**
     * @var \CouponURLs\App\Creation\Actions\ActionsFactory
     */
    protected $actionsFactory;
    /**
     * @var \CouponURLs\App\Creation\Coupons\CouponOptionsFromCouponFactory
     */
    protected $optionsFactory;
    /**
     * @var \CouponURLs\App\Domain\Uris\Abilities\URI
     */
    protected $requestURI;
    use WillAlwaysMatch;

    public function __construct(WordPressDatabaseReadableDriver $readableDriver, WC_Discounts $discounts, ActionsFactory $actionsFactory, CouponOptionsFromCouponFactory $optionsFactory, URI $requestURI)
    {
        $this->readableDriver = $readableDriver;
        $this->discounts = $discounts;
        $this->actionsFactory = $actionsFactory;
        $this->optionsFactory = $optionsFactory;
        $this->requestURI = $requestURI;
    }
    
    static public function type(): string
    {
        return CouponURLsFinder::class;   
    } 

    public function create(): object
    {
        return new CouponURLsFinder(
            $this->readableDriver,
            new GenericSQLParameters(new PostMetaStructure),
            new QueryParametersFromStringMatchingCurrentRequestFactory(
                new QueryParametersFromStringFactory,
                new CouponURLsFromCouponIdFactory(
                    new CouponFactory($this->discounts),
                    $this->actionsFactory,
                    $this->optionsFactory
                ),
                $this->requestURI
            )
        );
    } 
}