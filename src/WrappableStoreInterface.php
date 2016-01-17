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

interface WrappableStoreInterface extends StoreInterface
{
    /**
     * @param callable $dispatcher
     *
     * @return $this
     */
    public function replaceDispatcher(callable $dispatcher);
}
