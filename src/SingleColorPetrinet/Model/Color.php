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

use SingleColorPetrinet\Service\Exception\ColorInvalidException;

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
    public function conflict(ColorInterface $color): bool
    {
        foreach ($color->getValues() as $key => $value) {
            if (isset($this->values[$key]) && $this->values[$key] !== $value) {
                return true;
            }
        }

        return false;
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
     * @param string $key
     * @param string $value
     */
    protected function setValue(string $key, string $value): void
    {
        if (!ctype_alnum($key) || !ctype_alnum($value)) {
            throw new ColorInvalidException('Key and value of color must be alphanumeric');
        }
        $this->values[$key] = $value;
    }
}
