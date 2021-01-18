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
     * @var array
     */
    protected array $values = [];

    /**
     * Color constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->setValues($values);
    }

    /**
     * {@inheritdoc}
     */
    public function setValues(array $values): void
    {
        $this->values = [];

        foreach ($values as $key => $value) {
            $this->setValue($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(ColorInterface $color): void
    {
        foreach ($color->getValues() as $key => $value) {
            $this->setValue($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setValue(string $key, $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(string $key)
    {
        return $this->values[$key] ?? null;
    }
}
