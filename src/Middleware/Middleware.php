<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\WrappableStoreInterface;

/*
 * todo: Move to separate package
 */

class Middleware extends AbstractMiddleware
{
    /**
     * @var callable
     */
    private $dispatcher;

    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function setDispatcher(callable $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @param WrappableStoreInterface $store
     *
     * @return $this
     */
    public function bind(WrappableStoreInterface $store)
    {
        return $this->registerDispatcher($this->dispatcher, $store);
    }
}
