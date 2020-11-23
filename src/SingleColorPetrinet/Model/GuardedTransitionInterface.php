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

use Petrinet\Model\TransitionInterface;

/**
 * Interface for guarded transitions.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface GuardedTransitionInterface extends TransitionInterface
{
    /**
     * Sets id of transition.
     *
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * Gets guard of transition.
     */
    public function getGuard(): ?ExpressionInterface;

    /**
     * Sets guard of transition.
     *
     * @param ExpressionInterface $guard
     */
    public function setGuard(ExpressionInterface $guard);
}
