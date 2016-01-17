<?php

namespace Rb\Rephlux;

interface WrappableStoreInterface extends StoreInterface
{
    /**
     * @param array|callable $dispatcher
     *
     * @return $this
     */
    public function replaceDispatcher($dispatcher);
}
