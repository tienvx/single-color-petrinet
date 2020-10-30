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
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Service\Exception\OutputArcExpressionConflictException;

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
    private $colorfulFactory;

    /**
     * The expression evaluator.
     *
     * @var ExpressionEvaluatorInterface
     */
    private $expressionEvaluator;

    /**
     * Creates a new transition service.
     *
     * @param ColorfulFactoryInterface $colorfulFactory
     * @param ExpressionEvaluatorInterface $expressionEvaluator
     */
    public function __construct(ColorfulFactoryInterface $colorfulFactory, ExpressionEvaluatorInterface $expressionEvaluator)
    {
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

        if ($transition instanceof GuardedTransitionInterface &&
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
            // Calculates new colors
            $newColors = [];
            foreach ($transition->getOutputArcs() as $arc) {
                if ($arc instanceof ExpressionalOutputArcInterface && $arc->getExpression() instanceof ExpressionInterface) {
                    $result = $this->expressionEvaluator->evaluate($arc->getExpression(), $marking->getColor());
                    $newColor = $this->colorfulFactory->createColor($result);
                    $newColors[] = $newColor;
                }
            }

            // Checks color conflict
            for ($i = 0; $i < count($newColors) - 1; $i++) {
                if ($newColors[$i]->conflict($newColors[$i + 1])) {
                    throw new OutputArcExpressionConflictException("Output arc's expressions conflict.");
                }
            }
        }

        parent::fire($transition, $marking);

        if ($marking instanceof ColorfulMarkingInterface) {
            // Merge all new colors to a single color
            foreach ($newColors as $newColor) {
                $marking->getColor()->fromArray($newColor->toArray());
            }
        }
    }
}
