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

use Petrinet\Model\Petrinet as BasePetrinet;
use OutOfRangeException;

/**
 * Implementation of PetrinetInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class Petrinet extends BasePetrinet implements PetrinetInterface
{
    public function getPlaceById(int $id): PlaceInterface
    {
        foreach ($this->places as $place) {
            if ($place instanceof PlaceInterface && $place->getId() === $id) {
                return $place;
            }
        }
        throw new OutOfRangeException(sprintf('Place with id %d not found', $id));
    }

    public function getTransitionById(int $id): GuardedTransitionInterface
    {
        foreach ($this->transitions as $transition) {
            if ($transition instanceof GuardedTransitionInterface && $transition->getId() === $id) {
                return $transition;
            }
        }
        throw new OutOfRangeException(sprintf('Transition with id %d not found', $id));
    }
}
