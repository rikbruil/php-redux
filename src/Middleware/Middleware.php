<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\Dispatcher\DispatcherInterface;
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
     * {@inheritdoc}
     */
    public function bind(WrappableStoreInterface $store)
    {
        $oldDispatcher = $store->getCurrentDispatcher();
        $newDispatcher = $this->dispatcher;

        if ($newDispatcher instanceof  DispatcherInterface) {
            $newDispatcher->setCurrentDispatcher($oldDispatcher);
        }

        $store->replaceDispatcher($newDispatcher);

        return $this;
    }
}
