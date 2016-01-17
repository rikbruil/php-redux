<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\StoreInterface;
use Rb\Rephlux\WrappableStoreInterface;

interface MiddlewareInterface extends StoreInterface
{
    /**
     * @param WrappableStoreInterface $store
     *
     * @return $this
     */
    public function wrapStore(WrappableStoreInterface $store);
}
