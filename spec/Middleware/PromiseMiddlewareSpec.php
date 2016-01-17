<?php

namespace spec\Rb\Rephlux\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Rephlux\Middleware\MiddlewareInterface;
use Rb\Rephlux\Middleware\PromiseMiddleware;
use Rb\Rephlux\WrappableStoreInterface;
use React\Promise\PromiseInterface;

class PromiseMiddlewareSpec extends ObjectBehavior
{
    function it_should_resolve_promises(WrappableStoreInterface $store, PromiseInterface $action)
    {
        $action->then(Argument::any())->willReturn($action);

        $dispatcher = function ($action) { return $action; };

        $store->getCurrentDispatcher()->willReturn($dispatcher);
        $store->replaceDispatcher(Argument::any())->shouldBeCalled();
        $store->dispatch($action)->willReturn($action);

        $this->shouldHaveType(PromiseMiddleware::class);
        $this->shouldImplement(MiddlewareInterface::class);

        $this->__invoke($store);
        $newDispatch = $this->getDispatcher($dispatcher);
        $newDispatch($action)->shouldReturn($action);
    }

    function it_should_resolve_regular_actions(WrappableStoreInterface $store)
    {
        $action = ['type' => 'foo'];
        $dispatcher = function ($action) { return $action; };

        $store->getCurrentDispatcher()->willReturn($dispatcher);
        $store->replaceDispatcher(Argument::any())->shouldBeCalled();
        $store->dispatch($action)->willReturn($action);

        $this->shouldHaveType(PromiseMiddleware::class);
        $this->shouldImplement(MiddlewareInterface::class);

        $this->wrapStore($store);
        $newDispatch = $this->getDispatcher($dispatcher);
        $newDispatch($action)->shouldReturn($action);
    }

    function it_should_call_get_state_on_the_wrapped_object(WrappableStoreInterface $store)
    {
        $state = 'foo';

        $dispatcher = function ($action) { return $action; };

        $store->getCurrentDispatcher()->willReturn($dispatcher);
        $store->replaceDispatcher(Argument::any())->shouldBeCalled();
        $store->getState()->willReturn($state);

        $this->wrapStore($store);
    }
}
