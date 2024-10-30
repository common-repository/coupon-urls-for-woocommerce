<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\App\Creation\Validators\SubscriberValidatorFactory;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Event\Exceptions\ExceptionHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\SubscriberRequiresEventHandler;
use CouponURLs\Original\Events\Wordpress\EventArguments;
use Exception;
use ReflectionMethod;
use ReflectionParameter;
use Throwable;
class EventHandler
{
    /**
     * @var \CouponURLs\Original\Events\Subscriber
     */
    protected $subscriber;
    /**
     * @var \CouponURLs\Original\Construction\Event\Exceptions\ExceptionHandlerFactory
     */
    protected $exceptionHandlerFactory;
    /**
     * @var \CouponURLs\Original\Events\Wordpress\EventArguments
     */
    private $eventArguments;
    public function __construct(Subscriber $subscriber, ExceptionHandlerFactory $exceptionHandlerFactory, SubscriberValidatorFactory $subscriberValidatorFactory = null)
    {
        $subscriberValidatorFactory = $subscriberValidatorFactory ?? new SubscriberValidatorFactory('development');
        $this->subscriber = $subscriber;
        $this->exceptionHandlerFactory = $exceptionHandlerFactory;
        $subscriberValidatorFactory->create($this->subscriber)->validate();
        $this->setCurrentInstanceIfItRequiresIt();
    }
    /**
     * @return mixed
     */
    public function handle(...$originalArguments)
    {
        try {
            return $this->handleEvent(...$originalArguments);
        } catch (Throwable $exception) {
            return $this->handleException($exception);
        }
    }
    protected function handleEvent(...$originalArguments)
    {
        $this->setEventArguments($originalArguments);
        if ($this->subscriberCanBeExecuted()) {
            return $this->subscriber->execute(...$this->requestedArgumentsFor('execute'));
        }
    }
    /**
     * @return mixed
     */
    protected function handleException(Throwable $exception)
    {
        (object) ($exceptionHandler = $this->exceptionHandlerFactory->create($this->subscriber));
        return $exceptionHandler->handle($exception);
    }
    public function requestedArgumentsFor(string $method) : array
    {
        (object) ($reflectionMethod = new ReflectionMethod($this->subscriber, $method));
        (object) ($methodParameters = new Collection($reflectionMethod->getParameters()));
        return $methodParameters->map(function (ReflectionParameter $reflectionParameter) {
            (string) ($name = $reflectionParameter->getName());
            if (!$this->eventArguments->getKeys()->contain($name)) {
                throw new Exception(\esc_html("Event does not have the requested argument: {$name}"));
            }
            return $this->eventArguments->get($name);
        })->asArray();
    }
    protected function setEventArguments(array $originalArguments) : void
    {
        $this->eventArguments = $this->subscriber->createEventArguments(...$originalArguments);
    }
    protected function subscriberCanBeExecuted() : bool
    {
        (array) ($requestedArguments = $this->requestedArgumentsFor('validator'));
        return $this->subscriber->validator(...$requestedArguments)->isValid();
    }
    protected function setCurrentInstanceIfItRequiresIt() : void
    {
        if ($this->subscriber instanceof SubscriberRequiresEventHandler) {
            $this->subscriber->setEventHandler($this);
        }
    }
}