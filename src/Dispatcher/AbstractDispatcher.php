<?php

namespace Rb\Rephlux\Dispatcher;

abstract class AbstractDispatcher implements DispatcherInterface
{
    /**
     * @var callable
     */
    private $dispatcher;

    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function setCurrentDispatcher(callable $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @return callable
     */
    public function getCurrentDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param array $action
     *
     * @return array
     */
    public function __invoke($action)
    {
        return $this->dispatch($action);
    }
}
