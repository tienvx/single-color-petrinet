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
 * Interface for token colors.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
interface ColorInterface
{
    /**
     * @param string $color
     */
    public function setColor(string $color): void;

    /**
     * @return string
     */
    public function getColor(): string;

    /**
     * @return array|null
     */
    public function getResult(): ?array;

    /**
     * @param array $result
     */
    public function setResult(array $result): void;
}
