<?php

namespace CouponURLs\Original\Creation\Abilities\Exceptionhandlers;

use CouponURLs\Original\Creation\Abilities\CanCreateEntity;
use CouponURLs\Original\Domain\Entity;
use Exception;
class CanCreateEntityWhenNotEmpty implements CanCreateEntity
{
    /**
     * @var \CouponURLs\Original\Creation\Abilities\CanCreateEntity
     */
    protected $canCreateEntity;
    /**
     * @var string
     */
    protected $exceptionMessage = "Cannot create, the data passed is empty";
    public function __construct(CanCreateEntity $canCreateEntity, string $exceptionMessage = "Cannot create, the data passed is empty")
    {
        $this->canCreateEntity = $canCreateEntity;
        $this->exceptionMessage = $exceptionMessage;
    }
    /**
     * @param mixed $data
     */
    public function createEntity($data) : Entity
    {
        $this->validate($data);
        return $this->canCreateEntity->createEntity($data);
    }
    public function validate($data) : void
    {
        if ($data === "" || $data === null) {
            throw new Exception(\esc_html($this->exceptionMessage));
        }
    }
}