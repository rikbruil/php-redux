<?php

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\Dispatcher\DispatcherInterface;
use Rb\Rephlux\WrappableStoreInterface;

class Chain extends AbstractMiddleware
{
    /**
     * @var \callable[]
     */
    private $dispatchers = [];

    /**
     * @param callable[] $dispatchers
     */
    public function __construct(array $dispatchers = [])
    {
        $this->setDispatchers($dispatchers);
    }

    /**
     * @param callable[] $dispatchers
     *
     * @return $this
     */
    public function setDispatchers(array $dispatchers)
    {
        array_map([$this, 'addDispatcher'], $dispatchers);

        return $this;
    }

    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function addDispatcher(callable $dispatcher)
    {
        $this->dispatchers[] = $dispatcher;

        return $this;
    }

    /**
     * @param WrappableStoreInterface $store
     *
     * @return $this
     */
    public function bind(WrappableStoreInterface $store)
    {
        $rest = $this->dispatchers;

        foreach ($rest as $dispatcher) {
            $last = $store->getCurrentDispatcher();
            $store->replaceDispatcher($dispatcher);

            if (!($dispatcher instanceof DispatcherInterface)) {
                continue;
            }

            $dispatcher->setCurrentDispatcher($last);
        }
    }
}
