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

use Closure;
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
     * Gets guard function of transition.
     */
    public function getGuard(): ?Closure;

    /**
     * Sets guard function of transition.
     *
     * @param Closure $guard
     */
    public function setGuard(Closure $guard);

    /**
     * Gets expression function of transition.
     */
    public function getExpression(): ?Closure;

    /**
     * Sets expression function of transition.
     *
     * @param Closure $expression
     */
    public function setExpression(Closure $expression);
}
