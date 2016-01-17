<?php

namespace Rb\Rephlux;

interface DispatcherStoreInterface
{
    /**
     * @param array $action The action to dispatch
     *
     * @return array
     */
    public function dispatch($action);

    /**
     * @return callable
     */
    public function getCurrentDispatcher();
}
