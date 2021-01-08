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

use Petrinet\Model\MarkingInterface as BaseMarkingInterface;

/**
 * Interface for markings.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ColorfulMarkingInterface extends BaseMarkingInterface
{
    /**
     * Gets color.
     *
     * @return ColorInterface
     */
    public function getColor(): ColorInterface;

    /**
     * Sets color.
     *
     * @param ColorInterface $color
     */
    public function setColor(ColorInterface $color): void;
}
