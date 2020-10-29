<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;

class ColorfulFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\ColorfulFactory');
    }

    function it_creates_an_expression()
    {
        $this->createExpression('count > 1')->shouldBeAnInstanceOf('SingleColorPetrinet\Model\Expression');
    }

    function it_throws_an_exception_if_the_object_is_not_an_expression_child()
    {
        $this->beConstructedWith('SingleColorPetrinet\Model\Color', '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The expression class must implement "SingleColorPetrinet\Model\ExpressionInterface".'))
            ->duringCreateExpression('')
        ;
    }

    function it_creates_a_token()
    {
        $this->createToken()->shouldBeAnInstanceOf('SingleColorPetrinet\Model\ColorfulToken');
    }

    function it_creates_a_color()
    {
        $this->createColor()->shouldBeAnInstanceOf('SingleColorPetrinet\Model\Color');
    }
}
