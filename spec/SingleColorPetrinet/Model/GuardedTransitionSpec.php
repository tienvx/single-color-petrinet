<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Expression;

class GuardedTransitionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\GuardedTransition');
    }

    function it_gets_and_sets_id()
    {
        $this->getId()->shouldReturn(null);
        $this->setId(123);
        $this->getId()->shouldReturn(123);
    }

    function it_gets_and_sets_guard()
    {
        $expression = new Expression('count > 1');
        $this->getGuard()->shouldReturn(null);
        $this->setGuard($expression);
        $this->getGuard()->shouldReturn($expression);
    }
}
