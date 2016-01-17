<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\StoreInterface;

interface MiddlewareInterface extends StoreInterface
{
    /**
     * @param StoreInterface $store
     */
    public function __construct(StoreInterface $store);
}
