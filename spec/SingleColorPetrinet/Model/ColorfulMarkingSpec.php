<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Color;

class ColorfulMarkingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\ColorfulMarking');
    }

    function it_gets_and_sets_color()
    {
        $color = new Color('{count: 1}');
        $this->setColor($color);
        $this->getColor()->shouldReturn($color);
    }
}
