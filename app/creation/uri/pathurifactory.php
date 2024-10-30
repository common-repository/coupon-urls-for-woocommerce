<?php

namespace CouponURLs\App\Creation\Uri;

use CouponURLs\Original\Creation\Entities\Abilities\OverloadableEntitiesFactory;
use CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory;
use CouponURLs\App\Domain\URIs\HomePageURI;
use CouponURLs\App\Domain\URIs\PathURI;
use CouponURLs\Original\Creation\Abilities\CanCreateEntity;
use CouponURLs\Original\Creation\Abilities\CanCreateEntityWithParameters;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entity;
use Symfony\Component\HttpFoundation\Request;
use function CouponURLs\Original\Utilities\Text\i;

class PathURIFactory implements CanCreateEntity, OverloadableEntitiesFactory
{
    /**
     * @var \CouponURLs\App\Creation\Uri\QueryParametersFromStringFactory
     */
    protected $queryParametersFactory;
    public function __construct(QueryParametersFromStringFactory $queryParametersFactory)
    {
        $this->queryParametersFactory = $queryParametersFactory;
    }
    
    /**
     * @param mixed $data
     */
    public function canCreateEntity($data): bool
    {
        return true;
    } 

    /**
     * @param mixed $data
     */
    public function createEntity($data): Entity
    {
        return new PathURI($this->queryParametersFactory->create(
            $data->get('query') ?? ''
        ), i($data->get('path') ?? '')->trimRight('/'));
    } 

    /**
     * @param mixed $data
     */
    public function canCreateEntities($data): bool
    {
        return false;        
    } 
}