<?php

namespace Rb\Rephlux;

interface StoreInterface extends DispatcherStoreInterface
{
    /**
     * @return mixed
     */
    public function getState();
}
