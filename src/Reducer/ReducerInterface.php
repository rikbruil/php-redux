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
