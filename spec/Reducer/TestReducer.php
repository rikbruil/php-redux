<?php

namespace spec\Rb\Redux\Reducer;

use Rb\Redux\Reducer\CallableReducer;

class TestReducer extends CallableReducer
{
    /**
     * Returns new state based on the current state and the given action.
     *
     * @param mixed $state
     * @param array $action
     *
     * @return mixed
     */
    public function reduce($state, array $action)
    {
        return $state;
    }
}
