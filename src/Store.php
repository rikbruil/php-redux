<?php

/*
 * This file is part of the Redux library.
 *
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace Rb\Redux;

use Rb\Redux\Exception\InvalidFlowException;
use Rb\Redux\Exception\MissingTypeException;

final class Store implements StoreInterface, WrappableStoreInterface
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
     * @param callable $reducer
     * @param mixed    $initialState
     */
    protected function __construct(callable $reducer, $initialState)
    {
        self::$reducer    = $reducer;
        self::$state      = $initialState;
        self::$dispatcher = function ($action) {
            return call_user_func([$this, 'baseDispatcher'], $action);
        };
    }

    /**
     * Creates a new store for this app.
     *
     * @param callable $reducer
     * @param mixed    $initialState
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
     * @param array $action
     *
     * @return array
     */
    private function baseDispatcher($action)
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
            self::$state         = call_user_func_array($reducer, [self::$state, $action]);
        } finally {
            self::$isDispatching = false;
        }

        foreach (self::$listeners as $listener) {
            $listener($this);
        }

        return $action;
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
        $dispatcher = self::$dispatcher;

        return call_user_func($dispatcher, $action);
    }

    /**
     * {@inheritdoc}
     */
    public function replaceDispatcher(callable $dispatcher)
    {
        self::$dispatcher = $dispatcher;

        return $this;
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

    /**
     * @return callable
     */
    public function getCurrentDispatcher()
    {
        return self::$dispatcher;
    }
}
