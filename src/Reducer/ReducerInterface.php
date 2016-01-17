<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
