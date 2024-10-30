<?php

namespace CouponURLs\App\Domain\Redirections;

use CouponURLs\App\Domain\Redirections\Abilities\Redirectable;
use CouponURLs\App\Domain\Redirections\Abilities\URL;
use CouponURLs\Original\System\Abilities\Exitable;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;
class WordPressURLRedirector implements Redirectable
{
    /**
     * @var \CouponURLs\App\Domain\Redirections\Abilities\URL
     */
    protected $url;
    /**
     * @var \CouponURLs\Original\Validation\Validator
     */
    protected $redirectionValidator;
    /**
     * @var \CouponURLs\Original\System\Abilities\Exitable
     */
    protected $exiter;
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $_;
    public function __construct(URL $url, Validator $redirectionValidator, Exitable $exiter, GlobalFunctionWrapper $_ = null)
    {
        $_ = $_ ?? new GlobalFunctionWrapper();
        $this->url = $url;
        $this->redirectionValidator = $redirectionValidator;
        $this->exiter = $exiter;
        $this->_ = $_;
    }
    public function canRedirect() : bool
    {
        return $this->redirectionValidator->isValid();
    }
    public function redirect() : void
    {
        wp_redirect(esc_url($this->url->get())) && $this->exiter->exit();
    }
}