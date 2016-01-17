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

interface StoreInterface extends DispatcherStoreInterface
{
    /**
     * @return mixed
     */
    public function getState();
}
