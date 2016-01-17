<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\StoreInterface;

interface MiddlewareInterface extends StoreInterface
{
    /**
     * @param StoreInterface $store
     *
     * @return $this
     */
    public function wrapStore(StoreInterface $store);
}
