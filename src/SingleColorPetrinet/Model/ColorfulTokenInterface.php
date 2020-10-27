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

use Petrinet\Model\TokenInterface;

/**
 * Interface for tokens.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ColorfulTokenInterface extends TokenInterface
{
    /**
     * Gets the color.
     *
     * @return ColorInterface
     */
    public function getColor(): ColorInterface;

    /**
     * Sets color of token.
     *
     * @param ColorInterface $color
     */
    public function setColor(ColorInterface $color);
}
