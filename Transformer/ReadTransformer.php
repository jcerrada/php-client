<?php

/*
 * This file is part of the Apisearch PHP Client.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace Apisearch\Transformer;

use Apisearch\Model\Item;

/**
 * Interface ReadTransformer.
 */
interface ReadTransformer
{
    /**
     * The item should be converted by this transformer.
     *
     * @param Item $item
     *
     * @return bool
     */
    public function isValidItem(Item $item): bool;

    /**
     * Create object by item.
     *
     * @param Item $item
     *
     * @return mixed
     */
    public function fromItem(Item $item);
}
