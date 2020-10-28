<?php

namespace spec\SingleColorPetrinet\Builder;

use Petrinet\Model\PlaceInterface;
use Petrinet\Model\TransitionInterface;
use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;

class SingleColorPetrinetBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(ColorfulFactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
        $this->shouldHaveType('SingleColorPetrinet\Builder\SingleColorPetrinetBuilder');
    }

    function it_connects_a_transition_to_a_place_with_expression(
        ColorfulFactoryInterface $factory,
        ExpressionalOutputArcInterface $arc,
        TransitionInterface $transition,
        PlaceInterface $place,
        ExpressionInterface $expression
    )
    {
        $factory->createOutputArc()->willReturn($arc);

        $arc->setTransition($transition)->shouldBeCalled();
        $arc->setPlace($place)->shouldBeCalled();
        $arc->setWeight(1)->shouldBeCalled();
        $arc->setExpression($expression)->shouldBeCalled();

        $transition->addOutputArc($arc)->shouldBeCalled();
        $place->addInputArc($arc)->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->connect($transition, $place, 1, $expression)->shouldReturn($this);
    }

    function it_create_a_transition_with_guard(
        ColorfulFactoryInterface $factory,
        GuardedTransitionInterface $transition,
        ExpressionInterface $guard
    ) {
        $factory->createTransition()->willReturn($transition);
        $transition->setGuard($guard)->shouldBeCalled();
        $this->beConstructedWith($factory);
        $this->transition($guard)->shouldReturn($transition);
    }
}
