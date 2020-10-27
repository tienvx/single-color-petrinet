<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SingleColorPetrinet\Model\Color;

class ColorfulTokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\ColorfulToken');
    }

    function it_gets_and_sets_color()
    {
        $color = new Color();
        $this->setColor($color);
        $this->getColor()->shouldReturn($color);
    }
}
