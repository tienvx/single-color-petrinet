<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;

class ExpressionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('total > count * 2');
        $this->shouldHaveType('SingleColorPetrinet\Model\Expression');
    }

    function it_casts_to_string()
    {
        $this->beConstructedWith('1 + 2 === 3');
        $this->__toString()->shouldBe('1 + 2 === 3');
    }
}
