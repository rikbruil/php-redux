<?php

namespace Rb\Rephlux;

interface StoreInterface
{
    /**
     * @param array $action The action to dispatch
     *
     * @return array
     */
    public function dispatch($action);

    /**
     * @return mixed
     */
    public function getState();
}
