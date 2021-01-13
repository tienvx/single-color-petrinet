<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Model;

use Petrinet\Model\Factory;
use Petrinet\Model\InputArc;
use Petrinet\Model\OutputArc;
use Petrinet\Model\Petrinet;
use Petrinet\Model\PlaceMarking;
use Petrinet\Model\Token;

/**
 * Implementation of FactoryInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class ColorfulFactory extends Factory implements ColorfulFactoryInterface
{
    private string $colorClass;
    private string $expressionClass;

    /**
     * {@inheritdoc}
     *
     * @param string $colorClass
     */
    public function __construct(
        $colorClass = Color::class,
        $expressionClass = Expression::class,
        $petrinetClass = Petrinet::class,
        $placeClass = Place::class,
        $transitionClass = GuardedTransition::class,
        $inputArcClass = InputArc::class,
        $outputArcClass = OutputArc::class,
        $placeMarkingClass = PlaceMarking::class,
        $tokenClass = Token::class,
        $markingClass = ColorfulMarking::class
    ) {
        $this->colorClass = $colorClass;
        $this->expressionClass = $expressionClass;
        parent::__construct(
            $petrinetClass,
            $placeClass,
            $transitionClass,
            $inputArcClass,
            $outputArcClass,
            $placeMarkingClass,
            $tokenClass,
            $markingClass
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createColor(array $values): ColorInterface
    {
        $color = new $this->colorClass($values);

        if (!$color instanceof ColorInterface) {
            throw new \RuntimeException(sprintf('The color class must implement "%s".', ColorInterface::class));
        }

        return $color;
    }

    /**
     * {@inheritdoc}
     */
    public function createExpression(string $expression): ExpressionInterface
    {
        $expression = new $this->expressionClass($expression);

        if (!$expression instanceof ExpressionInterface) {
            throw new \RuntimeException(
                sprintf('The expression class must implement "%s".', ExpressionInterface::class)
            );
        }

        return $expression;
    }
}
