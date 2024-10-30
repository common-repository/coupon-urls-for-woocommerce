<?php

namespace CouponURLs\App\Creation\Coupons\Couponurls;

use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Domain\CouponURLs\CouponURLs;
use CouponURLs\App\Domain\Uris\Abilities\URI;
use CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters;
use CouponURLs\Original\Creation\Entities\Abilities\OverloadableEntitiesFactory;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
/**
 * Expects:
 * [
 *      ['id' => x, 'post_id' => y, 'meta_value' => '', etc],
 *      ['id' => x, 'post_id' => y, 'meta_value' => '', etc],
 *      ['id' => x, 'post_id' => y, 'meta_value' => '', etc],
 *      etc
 * ]
 */
class QueryParametersFromStringMatchingCurrentRequestFactory implements CreatableEntitiesWithParameters, OverloadableEntitiesFactory
{
    /**
     * @var \CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory
     */
    protected $queryParametersFromStringFactory;
    /**
     * @var \CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters
     */
    protected $couponURLsFromCouponIdFactory;
    /**
     * @var \CouponURLs\App\Domain\Uris\Abilities\URI
     */
    protected $requestURI;
    public function __construct(QueryParametersFromStringFactory $queryParametersFromStringFactory, CreatableEntitiesWithParameters $couponURLsFromCouponIdFactory, URI $requestURI)
    {
        $this->queryParametersFromStringFactory = $queryParametersFromStringFactory;
        $this->couponURLsFromCouponIdFactory = $couponURLsFromCouponIdFactory;
        $this->requestURI = $requestURI;
    }
    /**
     * @param mixed $entitesData */
    public function createEntities($entitesData, Parameters $parameters) : \CouponURLs\Original\Domain\Entities
    {
        /*array|null*/
        $macthingRow = neblabs_collection([$entitesData])->find(\Closure::fromCallable([$this, 'canCreateEntity']));
        return $this->couponURLsFromCouponIdFactory->createEntities(
            #empty if no matching uri!
            neblabs_collection([$macthingRow['post_id'] ?? false])->filter(),
            $parameters
        );
    }
    /**
     * @param mixed $data
     */
    public function canCreateEntity($data) : bool
    {
        return is_array($data) && isset($data['meta_value']) && $this->queryMatchesRequestQuery($data);
    }
    /**
     * @param mixed $data
     */
    public function canCreateEntities($data) : bool
    {
        return is_array($data);
    }
    protected function queryMatchesRequestQuery(array $row) : bool
    {
        (object) ($queryParameters = $this->queryParametersFromStringFactory->create($row['meta_value']));
        return $this->requestURI->queryParameters()->hasAllOf($queryParameters);
    }
    /**
     * @param mixed $data
     */
    public function createEntity($data, Parameters $parameters) : Entity
    {
        return $this->couponURLsFromCouponIdFactory->createEntity($data['post_id'], $parameters);
    }
}