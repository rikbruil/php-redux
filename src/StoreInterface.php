<?php

namespace Rb\Rephlux;

interface StoreInterface extends DispatcherInterface
{
    /**
     * @return mixed
     */
    public function getState();
}
