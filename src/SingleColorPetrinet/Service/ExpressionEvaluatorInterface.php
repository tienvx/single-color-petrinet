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

use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\ExpressionInterface;

/**
 * Contract for expression evaluator services.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ExpressionEvaluatorInterface
{
    /**
     * Evaluates and return value of the expression.
     *
     * @param ExpressionInterface $expression
     * @param ColorInterface $color
     *
     * @return mixed
     */
    public function evaluate(ExpressionInterface $expression, ColorInterface $color);
}
