<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use CouponURLs\Original\Events\Handler\BuiltIn\OriginalInstallatorHandler;
use CouponURLs\Original\Events\Handler\BuiltIn\OriginalShortCodesRegistratorHandler;
return ['init' => [OriginalShortCodesRegistratorHandler::class], '__(shortId).loaded__' => [OriginalInstallatorHandler::class]];