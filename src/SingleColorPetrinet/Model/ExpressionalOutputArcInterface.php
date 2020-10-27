<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) FTien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Model;

use Petrinet\Model\OutputArcInterface;

/**
 * Interface for output arcs (from a transition to a place).
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ExpressionalOutputArcInterface extends OutputArcInterface
{
    /**
     * Gets expression of arc.
     */
    public function getExpression(): ?ExpressionInterface;

    /**
     * Sets expression of arc.
     *
     * @param ExpressionInterface $expression
     */
    public function setExpression(ExpressionInterface $expression);
}
