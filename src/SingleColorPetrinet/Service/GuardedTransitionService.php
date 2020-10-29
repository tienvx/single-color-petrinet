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
use Petrinet\Service\Exception\TransitionNotEnabledException;
use Petrinet\Service\TransitionService;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulMarkingInterface;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Service\Exception\MissingColorException;
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
            $marking instanceof ColorfulMarkingInterface &&
            $marking->getColor() instanceof ColorInterface
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
        if (!$this->isEnabled($transition, $marking)) {
            throw new TransitionNotEnabledException('Cannot fire a disabled transition.');
        }

        if (!$marking instanceof ColorfulMarkingInterface || !(($color = $marking->getColor()) instanceof ColorInterface)) {
            throw new MissingColorException('Missing color in marking');
        }

        // Calculates new colors
        $newColors = [];
        foreach ($transition->getOutputArcs() as $arc) {
            if ($arc instanceof ExpressionalOutputArcInterface && $arc->getExpression() instanceof ExpressionInterface) {
                $result = $this->expressionEvaluator->evaluate($arc->getExpression(), $color);
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

        // Remove tokens from the input places
        foreach ($transition->getInputArcs() as $arc) {
            $arcWeight = $arc->getWeight();
            $place = $arc->getPlace();
            $placeMarking = $marking->getPlaceMarking($place);
            $tokens = $placeMarking->getTokens();

            for ($i = 0; $i < $arcWeight; $i++) {
                $placeMarking->removeToken($tokens[$i]);
            }
        }

        // Add tokens to the output places
        foreach ($transition->getOutputArcs() as $arc) {
            $arcWeight = $arc->getWeight();
            $place = $arc->getPlace();
            $placeMarking = $marking->getPlaceMarking($place);

            if (null === $placeMarking) {
                $placeMarking = $this->colorfulFactory->createPlaceMarking();
                $placeMarking->setPlace($place);
                $marking->addPlaceMarking($placeMarking);
            }

            // Create the tokens
            $tokens = array();
            for ($i = 0; $i < $arcWeight; $i++) {
                $tokens[] = $this->colorfulFactory->createToken($color);
            }

            $placeMarking->setTokens($tokens);
        }

        // Merge all new colors to a single color
        foreach ($newColors as $newColor) {
            $color->fromArray($newColor->toArray());
        }
    }
}
