<?php

namespace Rb\Rephlux\Dispatcher;

use React\Promise\PromiseInterface;

/*
 * todo: Move to separate package
 */

class PromiseDispatcher extends AbstractDispatcher
{
    /**
     * {@inheritdoc}
     */
    public function dispatch($action)
    {
        $dispatch = $this->getCurrentDispatcher();

        if ($action instanceof PromiseInterface) {
            return $action->then($dispatch);
        }

        return call_user_func($dispatch, $action);
    }
}
