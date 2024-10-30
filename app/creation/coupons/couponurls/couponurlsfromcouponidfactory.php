<?php

namespace CouponURLs\App\Creation\Coupons\Couponurls;

use CouponURLs\App\Creation\Coupons\CouponFactory;
use CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl;
use CouponURLs\App\Domain\CouponURLs\CouponURLs;
use CouponURLs\App\Domain\CouponURLs\CouponURL;
use CouponURLs\Original\Creation\Abilities\CreatableEntitiesWithParameters;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\Domain\Entity;
use function CouponURLs\Original\Utilities\Collection\_;
class CouponURLsFromCouponIdFactory implements CreatableEntitiesWithParameters
{
    /**
     * @var \CouponURLs\App\Creation\Coupons\CouponFactory
     */
    protected $couponFactory;
    /**
     * @var \CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl
     */
    protected $actionsFactory;
    /**
     * @var \CouponURLs\App\Creation\Coupons\Couponurls\Abilities\CreatableFromCouponUrl
     */
    protected $optionsFactory;
    public function __construct(CouponFactory $couponFactory, CreatableFromCouponUrl $actionsFactory, CreatableFromCouponUrl $optionsFactory)
    {
        $this->couponFactory = $couponFactory;
        $this->actionsFactory = $actionsFactory;
        $this->optionsFactory = $optionsFactory;
    }
    /** @param mixed $data the coupon id */
    public function createEntity($data, Parameters $parameters) : Entity
    {
        (object) ($couponUrl = new CouponURL($this->couponFactory->createFromCodeOrID($data)));
        $couponUrl->setActions($this->actionsFactory->createFromCoupon($couponUrl->coupon));
        $couponUrl->setOptions($this->optionsFactory->createFromCoupon($couponUrl->coupon));
        return $couponUrl;
    }
    /**
     * @param mixed $entitesData */
    public function createEntities($entitesData, Parameters $parameters) : \CouponURLs\Original\Domain\Entities
    {
        return new CouponURLs(neblabs_collection([$entitesData])->map(function (int $id) use ($parameters) {
            return $this->createEntity($id, $parameters);
        }));
    }
}