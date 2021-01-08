<?php

namespace SingleColorPetrinet\Tests\Service;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\Expression;
use SingleColorPetrinet\Service\Exception\ExpressionInvalidException;
use SingleColorPetrinet\Service\ExpressionLanguageEvaluator;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @covers \SingleColorPetrinet\Service\ExpressionLanguageEvaluator
 * @covers \SingleColorPetrinet\Model\Expression
 * @covers \SingleColorPetrinet\Model\Color
 */
class ExpressionLanguageEvaluatorTest extends TestCase
{
    public function testEvaluateGuard(): void
    {
        $expression = new Expression('count > 1', true);
        $color = new Color(['count' => 2]);
        $expressionLanguage = new ExpressionLanguage();
        $evaluator = new ExpressionLanguageEvaluator($expressionLanguage);
        $this->assertTrue($evaluator->evaluate($expression, $color));
    }

    public function testEvaluateExpression(): void
    {
        $expression = new Expression('{count: count + 1}', false);
        $color = new Color(['count' => 2]);
        $expressionLanguage = new ExpressionLanguage();
        $evaluator = new ExpressionLanguageEvaluator($expressionLanguage);
        $this->assertSame(['count' => 3], $evaluator->evaluate($expression, $color));
    }

    public function testEvaluateInvalidGuard(): void
    {
        $expression = new Expression('["this", "is", count, "elements"]', true);
        $color = new Color(['count' => 2]);
        $expressionLanguage = new ExpressionLanguage();
        $evaluator = new ExpressionLanguageEvaluator($expressionLanguage);
        $this->expectException(ExpressionInvalidException::class);
        $this->expectExceptionMessage('Expression ["this", "is", count, "elements"] must be evaluated to boolean');
        $evaluator->evaluate($expression, $color);
    }

    public function testEvaluateInvalidExpression(): void
    {
        $expression = new Expression('"Not" ~ "an array"', false);
        $color = new Color(['count' => 2]);
        $expressionLanguage = new ExpressionLanguage();
        $evaluator = new ExpressionLanguageEvaluator($expressionLanguage);
        $this->expectException(ExpressionInvalidException::class);
        $this->expectExceptionMessage('Expression "Not" ~ "an array" must be evaluated to array');
        $evaluator->evaluate($expression, $color);
    }
}
