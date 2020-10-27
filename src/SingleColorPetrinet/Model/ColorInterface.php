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

/**
 * Interface for token colours.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ColorInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param array $values
     */
    public function fromArray(array $values);

    /**
     * @param ColorInterface $color
     *
     * @return bool
     */
    public function conflict(ColorInterface $color): bool;
}
