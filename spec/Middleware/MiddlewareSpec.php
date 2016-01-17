<?php

namespace spec\Rb\Redux\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Redux\Dispatcher\DispatcherInterface;
use Rb\Redux\Middleware\MiddlewareInterface;
use Rb\Redux\Middleware\Middleware;
use Rb\Redux\WrappableStoreInterface;

class MiddlewareSpec extends ObjectBehavior
{
    function it_should_accept_dispatchers(WrappableStoreInterface $store)
    {
        $dispatcherA = function () {};
        $dispatcherB = function () {};

        $this->shouldHaveType(Middleware::class);
        $this->shouldImplement(MiddlewareInterface::class);

        $store->getCurrentDispatcher()->willReturn($dispatcherA);
        $store->replaceDispatcher($dispatcherB)->shouldBeCalled();

        $this->setDispatcher($dispatcherB);
        $this->__invoke($store);
    }

    function it_should_accept_dispatcher_interface(WrappableStoreInterface $store, DispatcherInterface $dispatcher)
    {
        $oldDispatcher = function () {};

        $store->getCurrentDispatcher()->willReturN($oldDispatcher);
        $store->replaceDispatcher($dispatcher)->shouldBeCalled();

        $this->setDispatcher($dispatcher);
        $this->__invoke($store);
    }
}
