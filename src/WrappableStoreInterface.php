<?php

/*
 * This file is part of the Rephlux library.
 * (c) Rik Bruil <rikbruil@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rb\Rephlux;

interface WrappableStoreInterface extends StoreInterface
{
    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function replaceDispatcher(callable $dispatcher);
}
