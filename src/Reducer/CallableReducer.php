<?php

namespace Rb\Rephlux\Reducer;

abstract class CallableReducer implements ReducerInterface
{
    /**
     * Make the class a callable by executing the reduce method when invoking the class.
     *
     * @see ReducerInterface::reduce
     *
     * @param mixed $state
     * @param array $action
     *
     * @return mixed
     */
    public function __invoke($state, array $action)
    {
        return $this->reduce($state, $action);
    }
}
