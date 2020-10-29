<?php

/**
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Builder;

use Petrinet\Builder\MarkingBuilder;
use Petrinet\Model\FactoryInterface;
use Petrinet\Model\PlaceInterface;
use SingleColorPetrinet\Model\ColorInterface;

/**
 * Helps building markings.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class SingleColorMarkingBuilder extends MarkingBuilder
{
    /**
     * The factory.
     *
     * @var FactoryInterface
     */
    private $factory;

    /**
     * {@inheritdoc}
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
        parent::__construct($factory);
    }

    /**
     * {@inheritdoc}
     */
    public function mark(PlaceInterface $place, $tokens)
    {
        $color = func_num_args() === 3 ? func_get_arg(2) : null;
        if (is_int($tokens) && $color instanceof ColorInterface) {
            $tokensCount = $tokens;
            $tokens = array();

            for ($i = 0; $i < $tokensCount; $i++) {
                $tokens[] = $this->factory->createToken($color);
            }
        }

        return parent::mark($place, $tokens);
    }
}
