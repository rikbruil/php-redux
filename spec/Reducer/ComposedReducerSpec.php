<?php

namespace spec\Rb\Redux\Reducer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rb\Redux\Reducer\CallableReducer;
use Rb\Redux\Reducer\ComposedReducer;
use Rb\Redux\Reducer\ReducerInterface;

class ComposedReducerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ComposedReducer::class);
        $this->shouldHaveType(CallableReducer::class);
        $this->shouldImplement(ReducerInterface::class);
    }

    function it_should_accept_reducers_through_constructor(TestReducer $reducerA, TestReducer $reducerB)
    {
        $action = ['type' => 'bar'];

        $state = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];

        $reducerA->reduce($state['foo'], $action)->willReturn($state['foo']);
        $reducerB->reduce($state['bar'], $action)->willReturn($state['bar']);

        $this->beConstructedWith([
            'foo' => $reducerA,
            'bar' => $reducerB,
        ]);

        $this->reduce($state, $action)->shouldReturn($state);
    }
}