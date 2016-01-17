<?php

namespace spec\Rb\Rephlux\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Rephlux\Dispatcher\DispatcherInterface;
use Rb\Rephlux\Middleware\AbstractMiddleware;
use Rb\Rephlux\Middleware\Chain;
use Rb\Rephlux\Middleware\MiddlewareInterface;
use Rb\Rephlux\WrappableStoreInterface;

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
