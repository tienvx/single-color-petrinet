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

use Closure;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\TransitionInterface;
use Petrinet\Service\TransitionService;
use Petrinet\Service\TransitionServiceInterface;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulMarkingInterface;
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
     * @var TransitionServiceInterface
     */
    protected TransitionServiceInterface $decorated;

    /**
     * Creates a new transition service.
     *
     * @param ColorfulFactoryInterface $colorfulFactory
     * @param TransitionServiceInterface|null $decorated
     */
    public function __construct(
        ColorfulFactoryInterface $colorfulFactory,
        ?TransitionServiceInterface $decorated = null
    ) {
        $this->colorfulFactory = $colorfulFactory;
        $this->decorated = $decorated ?? new TransitionService($colorfulFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(TransitionInterface $transition, MarkingInterface $marking): bool
    {
        if (!$this->decorated->isEnabled($transition, $marking)) {
            return false;
        }

        if (
            $transition instanceof GuardedTransitionInterface &&
            $transition->getGuard() &&
            $marking instanceof ColorfulMarkingInterface
        ) {
            return (bool)call_user_func($transition->getGuard(), $marking->getColor());
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
    public function fire(TransitionInterface $transition, MarkingInterface $marking): void
    {
        $this->decorated->fire($transition, $marking);

        if (
            $transition instanceof GuardedTransitionInterface &&
            $transition->getExpression() &&
            $marking instanceof ColorfulMarkingInterface
        ) {
            $marking->getColor()->merge($this->colorfulFactory->createColor(
                (array)call_user_func($transition->getExpression(), $marking->getColor())
            ));
        }
    }
}
