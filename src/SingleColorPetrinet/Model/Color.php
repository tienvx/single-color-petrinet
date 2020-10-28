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
 * Implementation of ColourInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class Color implements ColorInterface
{
    /**
     * @var array
     */
    protected $data = [];

    public function __construct(array $values = [])
    {
        $this->fromArray($values);
    }

    public function set(string $key, string $value)
    {
        $this->data[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function fromArray(array $values)
    {
        foreach ($values as $key => $value)
        {
            $this->set($key, $value);
        }
    }

    public function conflict(ColorInterface $color): bool
    {
        foreach ($color->toArray() as $key => $value) {
            if ($this->has($key) && $this->get($key) !== $value) {
                return true;
            }
        }

        return false;
    }
}
