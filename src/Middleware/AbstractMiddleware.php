<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\WrappableStoreInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(WrappableStoreInterface $store)
    {
        return $this->wrapStore($store);
    }
}
