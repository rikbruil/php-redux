<?php

/*
 * This file is part of the Redux library.
 *
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace Rb\Redux\Middleware;

use Rb\Redux\Dispatcher\DispatcherInterface;
use Rb\Redux\WrappableStoreInterface;

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
        return $this->apply($store);
    }
}
