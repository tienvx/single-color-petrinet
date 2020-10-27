<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Builder;

use Petrinet\Builder\PetrinetBuilder;
use Petrinet\Model\FactoryInterface;
use Petrinet\Model\NodeInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\TransitionInterface;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\ExpressionInterface;

/**
 * Helps building Single Color Petrinets.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class SingleColorPetrinetBuilder extends PetrinetBuilder
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
    public function connect(NodeInterface $source, NodeInterface $target, $weight = 1)
    {
        $expression = func_num_args() === 4 ? func_get_arg(3) : null;
        if (
            $this->factory instanceof ColorfulFactoryInterface &&
            $expression instanceof ExpressionInterface &&
            $source instanceof TransitionInterface &&
            $target instanceof PlaceInterface
        ) {
            $arc = $this->factory->createOutputArc();
            $arc->setPlace($target);
            $arc->setTransition($source);
            if ($arc instanceof ExpressionalOutputArcInterface) {
                $arc->setExpression($expression);
            }

            $arc->setWeight($weight);
            $source->addOutputArc($arc);
            $target->addInputArc($arc);

            return $this;
        } else {
            return parent::connect($source, $target, $weight);
        }
    }
}
