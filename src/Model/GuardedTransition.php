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

use Closure;
use Petrinet\Model\Transition;

/**
 * Implementation of GuardedTransitionInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class GuardedTransition extends Transition implements GuardedTransitionInterface
{
    /**
     * @var Closure|null
     */
    protected ?Closure $guard = null;

    /**
     * @var Closure|null
     */
    protected ?Closure $expression = null;

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
    public function getGuard(): ?Closure
    {
        return $this->guard;
    }

    /**
     * {@inheritdoc}
     */
    public function setGuard(Closure $guard)
    {
        $this->guard = $guard;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression(): ?Closure
    {
        return $this->expression;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpression(Closure $expression)
    {
        $this->expression = $expression;
    }
}
