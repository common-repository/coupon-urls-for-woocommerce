<?php

namespace CouponURLs\Original\Domain;

use CouponURLs\Original\Validation\Abilities\Validatable;
use CouponURLs\Original\Validation\Validator;
abstract class Entity implements Validatable
{
    public function validate(Validator $validator)
    {
        $validator->validate();
    }
}