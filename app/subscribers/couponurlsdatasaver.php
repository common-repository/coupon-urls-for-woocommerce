<?php

namespace CouponURLs\App\Subscribers;

use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\App\Components\Components;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use CouponURLs\Original\Events\Parts\DefaultPriority;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use CouponURLs\Original\Validation\Validator;
use CouponURLs\Original\Validation\Validators;
use CouponURLs\Original\Validation\Validators\ValidWhen;
use Symfony\Component\HttpFoundation\Request;
use WP_Post;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Text\i;
class CouponURLsDataSaver implements Subscriber
{
    /**
     * @var \CouponURLs\App\Components\Components
     */
    protected $actionComponents;
    use DefaultPriority;
    public function __construct(Components $actionComponents)
    {
        $this->actionComponents = $actionComponents;
    }
    public function createEventArguments(int $postId, WP_Post $post) : EventArguments
    {
        return new EventArguments(neblabs_collection(['post' => $post, 'requestData' => neblabs_collection([Request::createFromGlobals()->request->all()])]));
    }
    public function validator(WP_Post $post, Collection $requestData) : Validator
    {
        return new Validators([new ValidWhen($post->post_type === 'shop_coupon'), new ValidWhen(function () use ($requestData) {
            return (bool) wp_verify_nonce(sanitize_text_field(wp_unslash($requestData->get(Env::getWithPrefix('dashboard_nonce')))), Env::getWithPrefix('dashboard_nonce'));
        })]);
    }
    public function execute(WP_Post $post, Collection $requestData) : void
    {
        /**
         * This is a very quick & dirty (but safe!) way to save the data.
         * This needs a rewrite though cause having all of this in the same place
         * is not good.
         */
        (object) ($state = i(sanitize_text_field(wp_unslash($requestData->get('coupon_urls_state'))))->import());
        update_post_meta($post->ID, Env::getWithPrefix('options'), wp_json_encode($state->options));
        // dont save it since the user may not have entered any data!
        if (!$state->options['isEnabled']) {
            return;
        }
        (object) ($queryParameters = neblabs_collection([$state->queryParameters])->map(function (array $parameter) {
            return i("{$parameter['key']}={$parameter['value']}")->trim()->removeRight('=');
        })->implode('&'));
        (string) ($uri = "{$state->uri['type']}|{$state->uri['value']}");
        (object) ($actions = neblabs_collection([$state->actions ?? []]));
        update_post_meta($post->ID, Env::getWithPrefix('query'), (string) $queryParameters);
        update_post_meta($post->ID, Env::getWithPrefix('uri'), (string) $uri);
        $this->actionComponents->all()->forEvery(function (Identifiable $actionComponent) use ($post) {
            return delete_post_meta($post->ID, Env::getWithPrefix("action_{$actionComponent->identifier()}"));
        });
        $actions = $this->sortActions($actions);
        $actions->forEvery(function (array $action) use ($post) {
            return update_post_meta($post->ID, Env::getWithPrefix("action_{$action['type']}"), neblabs_collection([$action['options'] ?? []])->asJson()->get());
        });
    }
    protected function sortActions(Collection $actions) : Collection
    {
        (object) ($sortedActions = neblabs_collection([]));
        (object) ($find = function (string $actionType) {
            return function (array $action) use ($actionType) {
                return $action['type'] === $actionType;
            };
        });
        (object) ($findNot = function (string $actionType) {
            return function (array $action) use ($actionType) {
                return $action['type'] !== $actionType;
            };
        });
        (array) ($correctOrder = ['AddProduct', 'AddCoupon', 'CouponToBeAddedNotificationMessage', 'CouponAddedToCartExtraNotificationMessage', 'Redirection']);
        foreach ($correctOrder as $actionType) {
            if ($actions->have($find($actionType))) {
                $sortedActions->push($actions->find($find($actionType)));
                $actions->filter($findNot($actionType));
            }
        }
        return $sortedActions;
    }
}