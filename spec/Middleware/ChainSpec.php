<?php

namespace spec\Rb\Redux\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Redux\Dispatcher\DispatcherInterface;
use Rb\Redux\Middleware\AbstractMiddleware;
use Rb\Redux\Middleware\Chain;
use Rb\Redux\Middleware\MiddlewareInterface;
use Rb\Redux\WrappableStoreInterface;

class ChainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Chain::class);
        $this->shouldHaveType(AbstractMiddleware::class);
        $this->shouldHaveType(MiddlewareInterface::class);
    }

    function it_should_bind_multiple_dispatchers(DispatcherInterface $dispatcherA, WrappableStoreInterface $store)
    {
        $store->getCurrentDispatcher()->willReturn(function () {});

        $dispatcherB = function () {};

        $store->replaceDispatcher($dispatcherA)->shouldBeCalled();
        $store->replaceDispatcher($dispatcherB)->shouldBeCalled();

        $this->setDispatchers([$dispatcherA, $dispatcherB]);

        $this->apply($store);
    }
}
