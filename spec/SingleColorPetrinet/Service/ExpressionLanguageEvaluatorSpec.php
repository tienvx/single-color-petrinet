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
        $this->evaluate(new Expression('count + 1 > count'), new Color(['count' => '2']))->shouldReturn(true);
        $this->evaluate(new Expression('"There are "~count~" products in cart"'), new Color(['count' => '7']))->shouldReturn('There are 7 products in cart');
    }
}
