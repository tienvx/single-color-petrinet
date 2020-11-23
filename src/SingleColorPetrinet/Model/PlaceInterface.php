<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Model;

use Petrinet\Model\PlaceInterface as BasePlaceInterface;

/**
 * Allow set id to place.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface PlaceInterface extends BasePlaceInterface
{
    /**
     * Sets id of place.
     *
     * @param int $id
     */
    public function setId(int $id): void;
}
