<?php

namespace Rb\Rephlux\Reducer;

interface ReducerInterface
{
    /**
     * Reduce the current state to a new state based on the given action: (state, action) => state.
     *
     * @param mixed $state  The current state
     * @param array $action The action to base the state modifications on
     *
     * @return mixed
     */
    public function reduce($state, array $action);
}
