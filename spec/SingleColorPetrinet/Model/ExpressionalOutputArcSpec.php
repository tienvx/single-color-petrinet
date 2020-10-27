<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Expression;

class ExpressionalOutputArcSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\ExpressionalOutputArc');
    }

    function it_gets_and_sets_expression()
    {
        $expression = new Expression('{count: count + 1}');
        $this->getExpression()->shouldReturn(null);
        $this->setExpression($expression);
        $this->getExpression()->shouldReturn($expression);
    }
}
