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
     * @param array $values
     */
    public function setValues(array $values): void;

    /**
     * @return array
     */
    public function getValues(): array;

    /**
     * @param ColorInterface $color
     */
    public function merge(ColorInterface $color): void;

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function getValue(string $key);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setValue(string $key, $value): void;
}
