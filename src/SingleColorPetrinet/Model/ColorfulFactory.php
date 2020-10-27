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

/**
 * Implementation of FactoryInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class ColorfulFactory extends Factory implements ColorfulFactoryInterface
{
    private $color;
    private $colorClass;
    private $expressionClass;

    /**
     * {@inheritdoc}
     *
     * @param string $colorClass
     */
    public function __construct(
        $colorClass = 'SingleColorPetrinet\Model\Color',
        $expressionClass = 'SingleColorPetrinet\Model\Expression',
        $petrinetClass = 'Petrinet\Model\Petrinet',
        $placeClass = 'Petrinet\Model\Place',
        $transitionClass = 'SingleColorPetrinet\Model\GuardedTransition',
        $inputArcClass = 'Petrinet\Model\InputArc',
        $outputArcClass = 'SingleColorPetrinet\Model\ExpressionalOutputArc',
        $placeMarkingClass = 'Petrinet\Model\PlaceMarking',
        $tokenClass = 'SingleColorPetrinet\Model\ColorfulToken',
        $markingClass = 'Petrinet\Model\Marking'
    ) {
        $this->colorClass = $colorClass;
        $this->color = $this->createColor();
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
     * Creates a new color instance.
     *
     * @return ColorInterface
     */
    protected function createColor()
    {
        $color = new $this->colorClass();

        if (!$color instanceof ColorInterface) {
            throw new \RuntimeException('The color class must implement "SingleColorPetrinet\Model\ColorInterface".');
        }

        return $color;
    }

    /**
     * {@inheritdoc}
     */
    public function getColor(): ColorInterface
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function createExpression(string $expression)
    {
        $expression = new $this->expressionClass($expression);

        if (!$expression instanceof ExpressionInterface) {
            throw new \RuntimeException('The expression class must implement "SingleColorPetrinet\Model\ExpressionInterface".');
        }

        return $expression;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken()
    {
        $token = parent::createToken();

        if ($token instanceof ColorfulTokenInterface) {
            $token->setColor($this->color);
        }

        return $token;
    }
}
