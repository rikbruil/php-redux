<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
