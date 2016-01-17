<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rb\Rephlux\Reducer;

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
            $state[$key] = $reducer($state[$key], $action);
        }

        return $state;
    }
}
