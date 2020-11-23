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

use Petrinet\Model\Place as BasePlace;

/**
 * Implementation of PlaceInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class Place extends BasePlace implements PlaceInterface
{
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
