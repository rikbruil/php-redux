<?php

namespace Rb\Rephlux;

interface WrappableStoreInterface extends StoreInterface
{
    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function replaceDispatcher(callable $dispatcher);
}
