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

use Petrinet\Model\FactoryInterface;

/**
 * The factory is the place where model instances are created.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ColorfulFactoryInterface extends FactoryInterface
{
    /**
     * Creates a new expression instance.
     *
     * @param string $expression
     * @param bool $guard
     *
     * @return ExpressionInterface
     */
    public function createExpression(string $expression, bool $guard = false);

    /**
     * Creates a new color instance.
     *
     * @param string $color
     *
     * @return ColorInterface
     */
    public function createColor(string $color): ColorInterface;
}
