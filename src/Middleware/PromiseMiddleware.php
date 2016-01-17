<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\WrappableStoreInterface;
use React\Promise\PromiseInterface;

/*
 * todo: Move to separate package
 */

class PromiseMiddleware extends AbstractMiddleware
{
    /**
     * {@inheritdoc}
     */
    public function wrapStore(WrappableStoreInterface $store)
    {
        $oldDispatcher = $store->getCurrentDispatcher();
        $dispatcher    = $this->getDispatcher($oldDispatcher);

        $store->replaceDispatcher($dispatcher);

        return $this;
    }

    /**
     * @param callable $dispatch
     *
     * @return \Closure
     */
    public function getDispatcher(callable $dispatch)
    {
        /*
         * @param $action
         * @return mixed|PromiseInterface
         */
        return function ($action) use ($dispatch) {
            if ($action instanceof PromiseInterface) {
                return $action->then($dispatch);
            }

            return call_user_func($dispatch, $action);
        };
    }
}
