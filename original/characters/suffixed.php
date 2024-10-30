<?php

namespace CouponURLs\Original\Characters;

use function CouponURLs\Original\Utilities\Text\i;
class Suffixed
{
    /**
     * @var string|\CouponURLs\Original\Characters\StringManager
     */
    protected $text;
    /**
     * @var string|\CouponURLs\Original\Characters\StringManager
     */
    protected $suffix;
    /**
     * @var \CouponURLs\Original\Characters\StringManager
     */
    protected $sufixed;
    /**
     * @param string|\CouponURLs\Original\Characters\StringManager $text
     * @param string|\CouponURLs\Original\Characters\StringManager $suffix
     */
    public function __construct($text, $suffix)
    {
        $this->text = $text;
        $this->suffix = $suffix;
        $this->text = i($text);
        $this->sufixed = $this->text->ensureRight($suffix);
    }
    public function withSuffix() : StringManager
    {
        return $this->sufixed;
    }
    public function withoutSuffix() : StringManager
    {
        return $this->text;
    }
}