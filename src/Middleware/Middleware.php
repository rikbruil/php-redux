<?php

/*
 * This file is part of the Redux library.
 *
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace Rb\Redux\Middleware;

use Rb\Redux\WrappableStoreInterface;

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
