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

use Petrinet\Model\PetrinetInterface as BasePetrinetInterface;

/**
 * Allow get place and transition by id.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface PetrinetInterface extends BasePetrinetInterface
{
    /**
     * @param int $id
     *
     * @return GuardedTransitionInterface
     */
    public function getTransitionById(int $id): GuardedTransitionInterface;

    /**
     * @param int $id
     *
     * @return PlaceInterface
     */
    public function getPlaceById(int $id): PlaceInterface;
}
