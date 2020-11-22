<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;

class ExpressionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('total > count * 2', true);
        $this->shouldHaveType('SingleColorPetrinet\Model\Expression');
    }

    function it_return_expression()
    {
        $this->beConstructedWith('{key: 3}');
        $this->getExpression()->shouldBe('{key: 3}');
    }

    function it_return_is_guard()
    {
        $this->beConstructedWith('1 + 2 === 3', true);
        $this->isGuard()->shouldBe(true);
    }
}
