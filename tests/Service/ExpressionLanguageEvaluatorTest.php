<?php

namespace SingleColorPetrinet\Tests\Service;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\Expression;
use SingleColorPetrinet\Service\ExpressionLanguageEvaluator;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @covers \SingleColorPetrinet\Service\ExpressionLanguageEvaluator
 * @covers \SingleColorPetrinet\Model\Expression
 * @covers \SingleColorPetrinet\Model\Color
 */
class ExpressionLanguageEvaluatorTest extends TestCase
{
    public function testEvaluateExpression(): void
    {
        $expression = new Expression('count > 1');
        $expressionLanguage = new ExpressionLanguage();
        $evaluator = new ExpressionLanguageEvaluator($expressionLanguage);
        $this->assertTrue($evaluator->evaluate($expression, new Color(['count' => 2])));
        $this->assertFalse($evaluator->evaluate($expression, new Color(['count' => 0])));
    }
}
