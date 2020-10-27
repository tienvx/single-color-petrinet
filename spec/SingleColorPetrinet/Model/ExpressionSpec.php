<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Expression;

class ExpressionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('total + count * 2');
        $this->shouldHaveType('SingleColorPetrinet\Model\Expression');
    }

    function it_casts_to_string()
    {
        $this->beConstructedWith('total + count * 2');
        $this->__toString()->shouldBe('total + count * 2');
    }
}
