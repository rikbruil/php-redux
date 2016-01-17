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

        $this->beConstructedWith($store);
        $this->shouldHaveType(PromiseMiddleware::class);
        $this->shouldImplement(StoreInterface::class);

        $this->dispatch($action)->shouldReturn($action);
    }

    function it_should_resolve_regular_actions(StoreInterface $store)
    {
        $action = ['type' => 'foo'];

        $store->dispatch($action)->willReturn($action);

        $this->beConstructedWith($store);
        $this->shouldHaveType(PromiseMiddleware::class);
        $this->shouldImplement(StoreInterface::class);

        $this->dispatch($action)->shouldReturn($action);
    }
}
