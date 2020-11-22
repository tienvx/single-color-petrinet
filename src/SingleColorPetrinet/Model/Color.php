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

/**
 * Implementation of ColorInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class Color implements ColorInterface
{
    /**
     * @var string
     */
    protected string $color;

    /**
     * @var array|null
     */
    protected ?array $result = null;

    /**
     * Color constructor.
     *
     * @param string $color
     */
    public function __construct(string $color)
    {
        $this->setColor($color);
    }

    /**
     * {@inheritdoc}
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
        $this->result = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult(): ?array
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function setResult(array $result): void
    {
        $this->result = $result;
    }
}
