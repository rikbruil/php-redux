<?php

namespace Rb\Rephlux\Dispatcher;

interface DispatcherInterface
{
    /**
     * @param array $action The action to dispatch
     *
     * @return array
     */
    public function dispatch($action);

    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function setCurrentDispatcher(callable $dispatcher);

    /**
     * @return callable
     */
    public function getCurrentDispatcher();

    /**
     * @param array $action
     *
     * @return array
     */
    public function __invoke($action);
}
