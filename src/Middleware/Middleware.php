<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rb\Rephlux\Middleware;

use Rb\Rephlux\WrappableStoreInterface;

class Middleware extends AbstractMiddleware
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
    public function setDispatcher(callable $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @param WrappableStoreInterface $store
     *
     * @return $this
     */
    public function apply(WrappableStoreInterface $store)
    {
        return $this->registerDispatcher($this->dispatcher, $store);
    }
}
