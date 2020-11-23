<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;

class PlaceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\Place');
    }

    function it_gets_and_sets_id()
    {
        $this->getId()->shouldReturn(null);
        $this->setId(123);
        $this->getId()->shouldReturn(123);
    }
}
