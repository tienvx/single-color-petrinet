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
     * Creates a new color instance.
     *
     * @param array $values
     *
     * @return ColorInterface
     */
    public function createColor(array $values): ColorInterface;
}
