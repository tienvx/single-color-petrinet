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

use Petrinet\Model\AbstractArc;

/**
 * Implementation of OutputArcInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class ExpressionalOutputArc extends AbstractArc implements ExpressionalOutputArcInterface
{
    /**
     * @var ExpressionInterface|null
     */
    protected ?ExpressionInterface $expression = null;

    /**
     * {@inheritdoc}
     */
    public function getExpression(): ?ExpressionInterface
    {
        return $this->expression;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpression(ExpressionInterface $expression)
    {
        $this->expression = $expression;
    }
}
