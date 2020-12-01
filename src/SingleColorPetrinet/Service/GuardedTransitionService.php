<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Service;

use Petrinet\Model\MarkingInterface;
use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\TransitionInterface;
use Petrinet\Service\TransitionService;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulMarkingInterface;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Service\Exception\ExpressionsConflictException;

/**
 * Implementation of the TransitionServiceInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class GuardedTransitionService extends TransitionService implements GuardedTransitionServiceInterface
{
    /**
     * The colorful factory.
     *
     * @var ColorfulFactoryInterface
     */
    protected ColorfulFactoryInterface $colorfulFactory;

    /**
     * The expression evaluator.
     *
     * @var ExpressionEvaluatorInterface
     */
    protected ExpressionEvaluatorInterface $expressionEvaluator;

    /**
     * Creates a new transition service.
     *
     * @param ColorfulFactoryInterface $colorfulFactory
     * @param ExpressionEvaluatorInterface $expressionEvaluator
     */
    public function __construct(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator
    ) {
        $this->colorfulFactory = $colorfulFactory;
        $this->expressionEvaluator = $expressionEvaluator;
        parent::__construct($colorfulFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(TransitionInterface $transition, MarkingInterface $marking)
    {
        if (!parent::isEnabled($transition, $marking)) {
            return false;
        }

        if (
            $transition instanceof GuardedTransitionInterface &&
            $transition->getGuard() instanceof ExpressionInterface &&
            $marking instanceof ColorfulMarkingInterface
        ) {
            return (bool)$this->expressionEvaluator->evaluate($transition->getGuard(), $marking->getColor());
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledTransitions(PetrinetInterface $petrinet, MarkingInterface $marking): array
    {
        $transitions = [];

        foreach ($petrinet->getTransitions() as $transition) {
            if ($this->isEnabled($transition, $marking)) {
                $transitions[] = $transition;
            }
        }

        return $transitions;
    }

    /**
     * {@inheritdoc}
     */
    public function fire(TransitionInterface $transition, MarkingInterface $marking)
    {
        if ($marking instanceof ColorfulMarkingInterface) {
            $colors = $this->getColors($transition, $marking);
            $this->validateColors($colors);
        }

        parent::fire($transition, $marking);

        if ($marking instanceof ColorfulMarkingInterface && is_array($colors)) {
            $this->mergeColors($marking->getColor(), $colors);
        }
    }

    /**
     * @param TransitionInterface $transition
     * @param ColorfulMarkingInterface $marking
     *
     * @return array
     */
    protected function getColors(TransitionInterface $transition, ColorfulMarkingInterface $marking): array
    {
        $colors = [];
        foreach ($transition->getOutputArcs() as $arc) {
            if (
                $arc instanceof ExpressionalOutputArcInterface &&
                $arc->getExpression() instanceof ExpressionInterface
            ) {
                $colors[] = $this->colorfulFactory->createColor(
                    (array)$this->expressionEvaluator->evaluate($arc->getExpression(), $marking->getColor())
                );
            }
        }

        return $colors;
    }

    /**
     * @param array $colors
     */
    protected function validateColors(array $colors): void
    {
        for ($i = 0; $i < count($colors) - 1; $i++) {
            if (
                $colors[$i] instanceof ColorInterface
                && $colors[$i + 1] instanceof ColorInterface
                && $colors[$i]->conflict($colors[$i + 1])
            ) {
                throw new ExpressionsConflictException("Expressions conflict.");
            }
        }
    }

    /**
     * @param ColorInterface $markingColor
     * @param array $colors
     */
    protected function mergeColors(ColorInterface $markingColor, array $colors): void
    {
        foreach ($colors as $color) {
            if ($color instanceof ColorInterface) {
                $markingColor->merge($color);
            }
        }
    }
}
