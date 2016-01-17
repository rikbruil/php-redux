<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rb\Rephlux\Dispatcher;

use React\Promise\PromiseInterface;

/*
 * todo: Move to separate package
 */

class PromiseDispatcher extends AbstractDispatcher
{
    /**
     * {@inheritdoc}
     */
    public function dispatch($action)
    {
        $dispatch = $this->getCurrentDispatcher();

        if ($action instanceof PromiseInterface) {
            return $action->then($dispatch);
        }

        return call_user_func($dispatch, $action);
    }
}
