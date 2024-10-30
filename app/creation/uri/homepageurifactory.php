<?php

namespace CouponURLs\App\Creation\Uri;

use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Domain\URIs\HomePageURI;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Creation\Abilities\CanCreateEntity;
use CouponURLs\Original\Creation\Abilities\CanCreateEntityWithParameters;
use CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters;
use CouponURLs\Original\Creation\Entities\Abilities\OverloadableEntitiesFactory;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entities;
use CouponURLs\Original\Domain\Entity;
use Symfony\Component\HttpFoundation\Request;
use function CouponURLs\Original\Utilities\Text\i;

class HomePageURIFactory implements CanCreateEntity, OverloadableEntitiesFactory
{
    /**
     * @var \CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory
     */
    protected $queryParametersFactory;
    public function __construct(QueryParametersFromStringFactory $queryParametersFactory)
    {
        $this->queryParametersFactory = $queryParametersFactory;
    }

    /** @param mixed $data The parse_url() parts */
    public function canCreateEntity($data): bool
    {
        (object) $currentPath = i($data->get('path'))->ensureRight('/');
        (object) $homePath = i('/');

        return $currentPath->is($homePath);
    } 

    /** @param mixed $data The parse_url() parts */
    public function createEntity($data): Entity
    {
        return new HomePageURI(
            $this->queryParametersFactory->create(
                $data->get('query') ?? ''
            )
        );
    } 

    /**
     * @param mixed $data
     */
    public function canCreateEntities($data): bool
    {
        return false;        
    } 
}