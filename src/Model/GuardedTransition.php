<?php

/**
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Model;

use Petrinet\Model\Transition;

/**
 * Implementation of GuardedTransitionInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class GuardedTransition extends Transition implements GuardedTransitionInterface
{
    /**
     * @var ExpressionInterface|null
     */
    protected ?ExpressionInterface $guard = null;

    /**
     * {@inheritdoc}
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getGuard(): ?ExpressionInterface
    {
        return $this->guard;
    }

    /**
     * {@inheritdoc}
     */
    public function setGuard(ExpressionInterface $guard)
    {
        $this->guard = $guard;
    }
}
