<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;

class ColorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('{count: 1}');
        $this->shouldHaveType('SingleColorPetrinet\Model\Color');
    }

    function it_set_a_color()
    {
        $this->beConstructedWith('{count: 1}');
        $this->getColor()->shouldReturn('{count: 1}');
    }

    function it_set_a_result()
    {
        $this->beConstructedWith('{count: 1}');
        $this->getResult()->shouldReturn(null);
        $this->setResult(['count' => 1]);
        $this->getResult()->shouldReturn(['count' => 1]);
    }
}
