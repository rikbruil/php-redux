<?php

/*
 * This file is part of the Redux library.
 *
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace Rb\Redux\Dispatcher;

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
