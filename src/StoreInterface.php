<?php

namespace Rb\Rephlux;

interface StoreInterface
{
    /**
     * @param array $action
     *
     * @return array
     */
    public function dispatch($action);

    /**
     * @return mixed
     */
    public function getState();
}
