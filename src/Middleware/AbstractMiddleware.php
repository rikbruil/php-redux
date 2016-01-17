<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\StoreInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(StoreInterface $store)
    {
        return $this->wrapStore($store);
    }
}
