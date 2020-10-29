<?php

namespace spec\SingleColorPetrinet\Builder;

use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulTokenInterface;
use SingleColorPetrinet\Model\ColorInterface;

class SingleColorMarkingBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(ColorfulFactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
        $this->shouldHaveType('SingleColorPetrinet\Builder\SingleColorMarkingBuilder');
    }

    function it_marks_a_place_with_the_specified_tokens_number_and_color(
        ColorfulFactoryInterface $factory,
        ColorfulTokenInterface $token,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        ColorInterface $color
    ) {
        $placeMarking->setTokens([$token, $token, $token])->shouldBeCalled();
        $placeMarking->setPlace($place)->shouldBeCalled();

        $factory->createPlaceMarking()->willReturn($placeMarking);
        $factory->createToken($color)->willReturn($token)->shouldBeCalledTimes(3);

        $this->beConstructedWith($factory);
        $this->mark($place, 3, $color)->shouldReturn($this);
    }
}
