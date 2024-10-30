<?php

namespace CouponURLs\Original\Validation\Abilities;

use CouponURLs\Original\Validation\Validator;
interface Validatable
{
    public function validate(Validator $validator);
}