<?php

namespace CouponURLs\App\Data\Savers;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators\PassingValidator;
class WordPressPostSaverComposite extends WordPressPostSaver
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $wordpressPostSavers;
    public function __construct(Collection $wordpressPostSavers)
    {
        $this->wordpressPostSavers = $wordpressPostSavers;
    }
    public function save(Collection $data)
    {
        $this->wordpressPostSavers->perform(['setPost' => $this->post])->filter(function (WordPressPostSaver $wordPressPostSaver) use ($data) {
            return $wordPressPostSaver->canBeSaved($data)->isValid();
        })->perform(['save' => $data]);
    }
    public function canBeSaved(Collection $data) : Validator
    {
        return new PassingValidator();
    }
}