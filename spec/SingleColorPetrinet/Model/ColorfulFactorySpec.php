<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;

class ColorfulFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\ColorfulFactory');
    }

    function it_creates_a_guard_expression()
    {
        $expression = $this->createExpression('count > 1', true);
        $expression->shouldBeAnInstanceOf('SingleColorPetrinet\Model\Expression');
        $expression->getExpression()->shouldReturn('count > 1');
        $expression->isGuard()->shouldReturn(true);
    }

    function it_creates_an_output_arc_expression()
    {
        $expression = $this->createExpression('{count: 1}', false);
        $expression->shouldBeAnInstanceOf('SingleColorPetrinet\Model\Expression');
        $expression->getExpression()->shouldReturn('{count: 1}');
        $expression->isGuard()->shouldReturn(false);
    }

    function it_throws_an_exception_if_the_object_is_not_an_expression_child()
    {
        $this->beConstructedWith('SingleColorPetrinet\Model\Color', '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The expression class must implement "SingleColorPetrinet\Model\ExpressionInterface".'))
            ->duringCreateExpression('')
        ;
    }

    function it_creates_a_color()
    {
        $this->createColor('{key: "value"}')->shouldBeAnInstanceOf('SingleColorPetrinet\Model\Color');
    }

    function it_throws_an_exception_if_the_object_is_not_a_color_child()
    {
        $this->beConstructedWith('\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The color class must implement "SingleColorPetrinet\Model\ColorInterface".'))
            ->duringCreateColor('')
        ;
    }
}
