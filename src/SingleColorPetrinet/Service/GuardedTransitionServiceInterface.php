<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Service;

use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\TransitionInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Service\TransitionServiceInterface;

/**
 * Contract for guarded transition services.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface GuardedTransitionServiceInterface extends TransitionServiceInterface
{
    /**
     * Gets all enabled transitions.
     *
     * @param PetrinetInterface $petrinet
     * @param MarkingInterface  $marking
     *
     * @return TransitionInterface[]
     */
    public function getEnabledTransitions(PetrinetInterface $petrinet, MarkingInterface $marking): array;
}
