<?php

namespace CouponURLs\Original\Data\Drivers\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Data\Drivers\Abilities\MultipleItemsReadableDriver;
use CouponURLs\Original\Data\Drivers\Abilities\ReadableDriver;
use CouponURLs\Original\Data\Drivers\Abilities\SingleItemReadableDriver;
use CouponURLs\Original\Data\Drivers\Abilities\SQLReadableDriver;
use CouponURLs\Original\Data\Query\Parameters;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use WP_Meta_Query;
use function CouponURLs\Original\Utilities\Collection\_;
class WordPressPostMetaReadableDriver implements ReadableDriver
{
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $globalFunctionWrapper;
    /**
     * @var \CouponURLs\Original\Data\Drivers\Abilities\SQLReadableDriver
     */
    protected $sqlReadableDriver;
    public function __construct(GlobalFunctionWrapper $globalFunctionWrapper, SQLReadableDriver $sqlReadableDriver)
    {
        $this->globalFunctionWrapper = $globalFunctionWrapper;
        $this->sqlReadableDriver = $sqlReadableDriver;
    }
    /**
     * @return mixed
     */
    public function findOne(Parameters $parameters)
    {
        return $this->findMetaData($parameters, true)->first();
    }
    public function findMany(Parameters $parameters) : Collection
    {
        return $this->findMetaData($parameters, false);
    }
    protected function findMetaData(Parameters $parameters, bool $returnSingle) : Collection
    {
        /**
         * SEE THE BOTTOM OF THIS FILE FOR EXPECTED STRUCTURES RETURNED BY \get_metadata()
         */
        return $this->getResultInCorrectFormat(
            //ideally, this should be separated into two classes, but oh, well. At this point I'm extremely overwhelmed by WordPress. Maybe later. Todo:
            //unfortunately, we cant use get_post_meta() since we need to get the meta_id
            $this->getUsingWPDB($parameters, $returnSingle),
            $parameters,
            $returnSingle
        );
    }
    protected function getUsingWPDB(Parameters $parameters, bool $returnSingle) : array
    {
        (object) ($fields = $parameters->structure()->fields());
        (string) ($postIdOr1 = $parameters->has('postId') ? $fields->field('postId')->name() : 1);
        (string) ($LIMIT = $returnSingle ? "LIMIT 1" : '');
        $parameters->add('query', "\n                SELECT * FROM {$parameters->structure()->name()}\n                WHERE {$postIdOr1} = ?\n                AND {$fields->field('key')->name()} = ?\n                {$LIMIT}\n            ");
        $parameters->add('parameters', [$parameters->has('postId') ? $parameters->get('postId') : 1, $parameters->get('key')]);
        // two options:  findone and findmany
        return $returnSingle ? $this->sqlReadableDriver->findOne($parameters) : $this->sqlReadableDriver->findMany($parameters)->asArray();
    }
    /**
     * @param mixed $result
     */
    public function getResultInCorrectFormat($result, Parameters $parameters, bool $returnSingle) : Collection
    {
        (object) ($createMeta = function ($result) use ($parameters) {
            return [$parameters->get('key') => $result];
        });
        /**
         * 
         *
         *
         * WELL WANT TO CHANGE THE MATCH HERE SINCE THE COMPILER DOESNT WORK WEHN
         * USED AS AEXPRESSION OTHER THEN A RETURN TYPE
         * 
         *
         */
        return neblabs_collection([(function () use ($returnSingle, $createMeta, $result, $parameters) {
            switch (true) {
                case $returnSingle:
                    return [$createMeta($result)];
                case $parameters->has('key'):
                    return neblabs_collection([$result])->map($createMeta)->asArray();
            }
        })()]);
    }
    // metadata_exists() for better performance;
    public function has(Parameters $parameters) : bool
    {
        return $this->findMany($parameters->get())->haveAny();
    }
    // again, it's much better that the count is performed in the database
    // for a proof of concept, right now we need this to work despite performance
    public function count(Parameters $parameters) : int
    {
        return $this->findMany($parameters)->count();
    }
}
/**  
 Structure when multiple items are returned AND NO key is specified:
   array(3) {
      ["_edit_last"]=>
      array(2) {
        [0]=>
        string(1) "1",
        [1]=>
        string(1) "2"
      }
      ["_wp_page_template"]=>
      array(1) {
        [0]=>
        string(5) "blank"
      }
    }
When a key has been specified: (eg: '_wp_page_template'):
   array(2) {
        [0]=>
        string(1) "1",
        [1]=>
        string(1) "2"
      }
*/