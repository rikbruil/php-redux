<?php

namespace spec\Rb\Rephlux\Dispatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Rephlux\WrappableStoreInterface;
use React\Promise\PromiseInterface;

class PromiseDispatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rb\Rephlux\Dispatcher\PromiseDispatcher');
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
