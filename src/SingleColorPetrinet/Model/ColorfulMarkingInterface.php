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
     * Gets the first (and single) color.
     *
     * @return ColorInterface|null
     */
    public function getColor(): ?ColorInterface;
}
