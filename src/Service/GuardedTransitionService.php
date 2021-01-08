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
use Petrinet\Service\TransitionServiceInterface;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulMarkingInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;

/**
 * Implementation of the GuardedTransitionServiceInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class GuardedTransitionService implements GuardedTransitionServiceInterface
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
     * @var TransitionServiceInterface
     */
    protected TransitionServiceInterface $decorated;

    /**
     * Creates a new transition service.
     *
     * @param ColorfulFactoryInterface $colorfulFactory
     * @param ExpressionEvaluatorInterface $expressionEvaluator
     * @param TransitionServiceInterface|null $decorated
     */
    public function __construct(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator,
        ?TransitionServiceInterface $decorated = null
    ) {
        $this->colorfulFactory = $colorfulFactory;
        $this->expressionEvaluator = $expressionEvaluator;
        $this->decorated = $decorated ?? new TransitionService($colorfulFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(TransitionInterface $transition, MarkingInterface $marking)
    {
        if (!$this->decorated->isEnabled($transition, $marking)) {
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
        $this->decorated->fire($transition, $marking);

        if (
            $transition instanceof GuardedTransitionInterface &&
            $transition->getExpression() instanceof ExpressionInterface &&
            $marking instanceof ColorfulMarkingInterface
        ) {
            $marking->getColor()->merge($this->colorfulFactory->createColor(
                (array)$this->expressionEvaluator->evaluate($transition->getExpression(), $marking->getColor())
            ));
        }
    }
}
