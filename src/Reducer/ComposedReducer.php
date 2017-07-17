<?php

/*
 * This file is part of the Redux library.
 *
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace Rb\Redux\Reducer;

class ComposedReducer extends CallableReducer
{
    /**
     * @var callable[]
     */
    protected $reducers = [];

    /**
     * ComposedReducer constructor.
     *
     * @param array $reducers
     */
    public function __construct(array $reducers = [])
    {
        foreach ($reducers as $key => $reducer) {
            $this->addReducer($key, $reducer);
        }
    }

    /**
     * Add a reducer for a given state key.
     *
     * @param string   $key
     * @param callable $reducer
     *
     * @return $this
     */
    public function addReducer($key, callable $reducer)
    {
        $this->reducers[$key] = $reducer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function reduce($state, array $action)
    {
        foreach ($this->reducers as $key => $reducer) {
            $currentState = isset($state[$key]) ? $state[$key] : null;
            $state[$key] = $reducer($currentState, $action);
        }

        return $state;
    }
}
