<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\WrappableStoreInterface;

interface MiddlewareInterface
{
    /**
     * @param WrappableStoreInterface $store
     *
     * @return $this
     */
    public function wrapStore(WrappableStoreInterface $store);
}
