<?php

namespace Rb\Rephlux;

use Rb\Rephlux\Exception\InvalidFlowException;
use Rb\Rephlux\Exception\MissingTypeException;
use Rb\Rephlux\Middleware\MiddlewareInterface;

final class Store implements StoreInterface
{
    const INIT = '@@INIT';

    /**
     * @var mixed
     */
    protected static $state;

    /**
     * @var callable
     */
    protected static $reducer;

    /**
     * @var callable[]
     */
    protected static $listeners = [];

    /**
     * @var bool
     */
    protected static $isDispatching = false;

    /**
     * @var callable
     */
    protected static $dispatcher;

    /**
     * @var MiddlewareInterface[]
     */
    protected static $middlewares = [];

    /**
     * @param callable $reducer
     * @param mixed    $initialState
     */
    protected function __construct(callable $reducer, $initialState)
    {
        self::$reducer    = $reducer;
        self::$state      = $initialState;
        self::$dispatcher = [$this, 'dispatcher'];
    }

    /**
     * Creates a new store for this app.
     *
     * @param callable $reducer
     * @param $initialState
     *
     * @return Store
     */
    public static function create(callable $reducer, $initialState)
    {
        $store = new self($reducer, $initialState);
        $store->dispatch(['type' => self::INIT]);

        return $store;
    }

    /**
     * Subscribe a listener to this store and return an unsubscribe function.
     *
     * @param callable $listener
     *
     * @return \Closure
     */
    public function subscribe(callable $listener)
    {
        self::$listeners[] = $listener;
        $isSubscribed      = true;

        /*
         * Unsubscribe the subscribed listener.
         * @return bool Returns true when the listener was actually removed (in case you call multiple times)
         */
        $unsubscribe = function () use (&$isSubscribed, $listener) {
            if (!$isSubscribed) {
                return false;
            }

            $isSubscribed = false;
            $index        = array_search($listener, self::$listeners, true);
            array_splice(self::$listeners, $index, 1);

            return true;
        };

        return $unsubscribe;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     * @throws MissingTypeException
     * @throws InvalidFlowException
     */
    public function dispatch($action)
    {
        if (!is_array($action)) {
            throw new \InvalidArgumentException('Action must be an array');
        }

        if (!isset($action['type'])) {
            throw new MissingTypeException();
        }

        /*
         * This edge-case is hard to mock, but easy to test in real-life by using it the wrong way
         */
        if (self::$isDispatching) {
            // @codeCoverageIgnoreStart
            throw new InvalidFlowException('Reducers may not dispatch new actions');
            // @codeCoverageIgnoreEnd
        }

        $reducer = self::$reducer;

        try {
            self::$isDispatching = true;
            self::$state         = $reducer(self::$state, $action);
        } finally {
            self::$isDispatching = false;
        }

        foreach (self::$listeners as $listener) {
            $listener($this);
        }

        return $action;
    }

    /**
     * @param callable $nextReducer
     *
     * @throws MissingTypeException
     * @throws \Exception
     */
    public function replaceReducer(callable $nextReducer)
    {
        self::$reducer = $nextReducer;
        $this->dispatch(['type' => self::INIT]);
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return self::$state;
    }
}
