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

/**
 * Implementation of ExpressionInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class Expression implements ExpressionInterface
{
    /**
     * @var string
     */
    protected string $expression;

    /**
     * @var bool
     */
    protected bool $guard;

    /**
     * Creates a new expression.
     *
     * @param string $expression
     * @param bool $guard
     */
    public function __construct(string $expression, bool $guard = false)
    {
        $this->expression = $expression;
        $this->guard = $guard;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression(): string
    {
        return $this->expression;
    }

    /**
     * {@inheritdoc}
     */
    public function isGuard(): bool
    {
        return $this->guard;
    }
}
