<?php

namespace spec\Rb\Rephlux\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Rephlux\Middleware\PromiseMiddleware;
use Rb\Rephlux\StoreInterface;
use React\Promise\PromiseInterface;

class PromiseMiddlewareSpec extends ObjectBehavior
{
    function it_should_resolve_promises(StoreInterface $store, PromiseInterface $action)
    {
        $action->then([$store, 'dispatch'])->willReturn($action);

        $this->shouldHaveType(PromiseMiddleware::class);
        $this->shouldImplement(StoreInterface::class);

        $this->__invoke($store);
        $this->dispatch($action)->shouldReturn($action);
    }

    function it_should_resolve_regular_actions(StoreInterface $store)
    {
        $action = ['type' => 'foo'];

        $store->dispatch($action)->willReturn($action);

        $this->shouldHaveType(PromiseMiddleware::class);
        $this->shouldImplement(StoreInterface::class);

        $this->wrapStore($store);
        $this->dispatch($action)->shouldReturn($action);
    }

    function it_should_call_get_state_on_the_wrapped_object(StoreInterface $store)
    {
        $state = 'foo';

        $store->getState()->willReturn($state);

        $this->wrapStore($store);

        $this->getState()->shouldReturn($state);
    }
}
