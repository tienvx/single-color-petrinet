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

use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Implementation of the ExpressionEvaluatorInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class ExpressionLanguageEvaluator implements ExpressionEvaluatorInterface
{
    /**
     * The expression language.
     *
     * @var ExpressionLanguage
     */
    protected ExpressionLanguage $expressionLanguage;

    /**
     * Creates a new expression evaluator.
     *
     * @param ExpressionLanguage $expressionLanguage
     */
    public function __construct(ExpressionLanguage $expressionLanguage)
    {
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(ExpressionInterface $expression, ColorInterface $color): bool
    {
        return (bool)$this->expressionLanguage->evaluate($expression->getExpression(), $color->getValues());
    }
}
