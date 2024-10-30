<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\ValidationResult;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use Exception;
use function CouponURLs\Original\Utilities\Text\i;
class PostTypeRedirectionValidator extends Validator
{
    /**
     * @var int
     */
    protected $postTypeId;
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $_;
    public function __construct(int $postTypeId, GlobalFunctionWrapper $_ = null)
    {
        $_ = $_ ?? new GlobalFunctionWrapper();
        $this->postTypeId = $postTypeId;
        $this->_ = $_;
    }
    public function execute() : ValidationResult
    {
        return $this->passWhen((bool) get_post($this->postTypeId));
        //todo: the url for that post is not the current url
    }
    protected function getDefaultException() : Exception
    {
        return new Exception(\esc_html('post type validation failed!'));
    }
}