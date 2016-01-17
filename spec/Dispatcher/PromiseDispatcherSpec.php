<?php

namespace spec\Rb\Redux\Dispatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Redux\Dispatcher\PromiseDispatcher;
use Rb\Redux\WrappableStoreInterface;
use React\Promise\PromiseInterface;

class PromiseDispatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PromiseDispatcher::class);
    }

    function it_should_dispatch_promises(PromiseInterface $action)
    {
        $dispatcher = function ($action) { return $action; };

        $action->then($dispatcher)->willReturn($action);

        $this->setCurrentDispatcher($dispatcher);
        $this->dispatch($action)->shouldReturn($action);
    }

    function it_should_dispatch_normal_actions()
    {
        $action = ['type' => 'foo'];

        $dispatcher = function ($action) { return $action; };

        $this->setCurrentDispatcher($dispatcher);
        $this($action)->shouldReturn($action);
    }
}
