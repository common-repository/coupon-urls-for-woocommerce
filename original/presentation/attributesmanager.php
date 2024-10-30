<?php

namespace CouponURLs\Original\Presentation;

use CouponURLs\Original\Collections\Collection;
class AttributesManager
{
    public function build(array $attribute)
    {
        (array) ($attribute = (new Collection($attribute))->mapWithKeys(function ($value, $name) {
            return ['key' => $name, 'value' => esc_attr($value)];
        })->asArray());
        return trim($attribute['value']) ? " {$attribute['name']}=\"{$attribute['value']}\"" : '';
    }
}