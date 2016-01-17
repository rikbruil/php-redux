<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
