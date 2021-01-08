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
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;

/**
 * Helps building Single Color Petrinets.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class SingleColorPetrinetBuilder extends PetrinetBuilder
{
    /**
     * The colorful factory.
     *
     * @var ColorfulFactoryInterface
     */
    protected ColorfulFactoryInterface $colorfulFactory;

    /**
     * {@inheritdoc}
     */
    public function __construct(ColorfulFactoryInterface $factory)
    {
        $this->colorfulFactory = $factory;
        parent::__construct($factory);
    }

    /**
     * {@inheritdoc}
     */
    public function transition()
    {
        $transition = parent::transition();
        if (!$transition instanceof GuardedTransitionInterface) {
            return $transition;
        }
        $guard = func_num_args() > 0 ? func_get_arg(0) : null;
        $expression = func_num_args() === 2 ? func_get_arg(1) : null;
        if (is_string($guard)) {
            $transition->setGuard($this->colorfulFactory->createExpression($guard, true));
        }
        if (is_string($expression)) {
            $transition->setExpression($this->colorfulFactory->createExpression($expression));
        }

        return $transition;
    }
}
