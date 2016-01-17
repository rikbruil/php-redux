<?php

/*
 * This file is part of the Rephlux library.
 *
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

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
