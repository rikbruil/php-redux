<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\Dispatcher\DispatcherInterface;
use Rb\Rephlux\WrappableStoreInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @param callable                $dispatcher
     * @param WrappableStoreInterface $store
     *
     * @return $this
     */
    protected function registerDispatcher(callable $dispatcher, WrappableStoreInterface $store)
    {
        $previous = $store->getCurrentDispatcher();

        if ($dispatcher instanceof DispatcherInterface) {
            $dispatcher->setCurrentDispatcher($previous);
        }

        $store->replaceDispatcher($dispatcher);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(WrappableStoreInterface $store)
    {
        return $this->bind($store);
    }
}
