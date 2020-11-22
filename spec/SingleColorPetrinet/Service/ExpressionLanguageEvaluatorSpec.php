<?php

namespace spec\SingleColorPetrinet\Service;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\Expression;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionLanguageEvaluatorSpec extends ObjectBehavior
{
    function it_is_initializable(ExpressionLanguage $expressionLanguage)
    {
        $this->beConstructedWith($expressionLanguage);
        $this->shouldHaveType('SingleColorPetrinet\Service\ExpressionLanguageEvaluator');
    }

    function it_evaluates_expression_with_color()
    {
        $this->beConstructedWith(new ExpressionLanguage());
        $this->evaluate(new Expression('count + 1 > count', true), new Color('{count: 2}'))->shouldReturn(true);
        $this->evaluate(new Expression('{count: count + 1}'), new Color('{count: 7}'))->shouldReturn([
            'count' => 8,
        ]);
    }
}
