<?php

namespace Rb\Rephlux;

interface DispatcherInterface
{
    /**
     * @param array $action The action to dispatch
     *
     * @return array
     */
    public function dispatch($action);
}
