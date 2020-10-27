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

use Petrinet\Model\Token;

/**
 * Implementation of TokenInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class ColorfulToken extends Token implements ColorfulTokenInterface
{
    /**
     * The color.
     *
     * @var ColorInterface
     */
    protected $color;

    /**
     * {@inheritdoc}
     */
    public function getColor(): ColorInterface
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function setColor(ColorInterface $color)
    {
        $this->color = $color;
    }
}
