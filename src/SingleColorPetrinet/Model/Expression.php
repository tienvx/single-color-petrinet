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
    protected $expression;

    /**
     * Creates a new expression.
     *
     * @param string $expression
     */
    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    public function __toString()
    {
        return $this->expression;
    }
}
