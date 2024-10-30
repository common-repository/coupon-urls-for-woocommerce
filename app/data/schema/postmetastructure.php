<?php

namespace CouponURLs\App\Data\Schema;

use CouponURLs\Original\Data\Schema\Fields;
use CouponURLs\Original\Data\Schema\Fields\Field;
use CouponURLs\Original\Data\Schema\Fields\ID;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Data\Schema\Structure;
use function CouponURLs\Original\Utilities\Collection\_;
class PostMetaStructure extends Structure
{
    public function name() : string
    {
        global $wpdb;
        return $wpdb->postmeta;
    }
    public function fields() : Fields
    {
        return new Fields(neblabs_collection([new Field('meta_id', 'id'), new Field('post_id', 'postId'), new Field('meta_key', 'key'), new Field('meta_value', 'value')]));
    }
}