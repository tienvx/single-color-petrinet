<?php

namespace spec\SingleColorPetrinet\Service;

use Petrinet\Model\InputArcInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use Petrinet\Model\TokenInterface;
use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulMarkingInterface;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\Expression;
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Service\Exception\OutputArcExpressionConflictException;
use SingleColorPetrinet\Service\ExpressionEvaluatorInterface;

class GuardedTransitionServiceSpec extends ObjectBehavior
{
    function it_is_initializable(ColorfulFactoryInterface $colorfulFactory, ExpressionEvaluatorInterface $expressionEvaluator)
    {
        $this->beConstructedWith($colorfulFactory, $expressionEvaluator);
        $this->shouldHaveType('SingleColorPetrinet\Service\GuardedTransitionService');
    }

    function it_tells_when_a_transition_is_enabled_if_guard_allows(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator,
        InputArcInterface $arc,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        GuardedTransitionInterface $transition,
        ColorfulMarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color
    ) {
        $this->mock_is_enabled($expressionEvaluator, [$arc], $place, $placeMarking, $transition, $marking, $token, $color, true);
        $this->beConstructedWith($colorfulFactory, $expressionEvaluator);
        $this->isEnabled($transition, $marking)->shouldReturn(true);
    }

    function it_tells_when_a_transition_is_disabled_if_guard_deny(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator,
        InputArcInterface $arc,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        GuardedTransitionInterface $transition,
        ColorfulMarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color
    )  {
        $this->mock_is_enabled($expressionEvaluator, [$arc], $place, $placeMarking, $transition, $marking, $token, $color, false);
        $this->beConstructedWith($colorfulFactory, $expressionEvaluator);
        $this->isEnabled($transition, $marking)->shouldReturn(false);
    }

    function it_updates_single_color_when_firing_a_transition(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator,
        ExpressionalOutputArcInterface $arc1,
        ExpressionalOutputArcInterface $arc2,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        GuardedTransitionInterface $transition,
        ColorfulMarkingInterface $marking,
        TokenInterface $token,
        TokenInterface $newToken,
        ColorInterface $color
    ) {
        $this->beConstructedWith($colorfulFactory, $expressionEvaluator);

        $this->mock_is_enabled($expressionEvaluator, [$arc1, $arc2], $place, $placeMarking, $transition, $marking, $token, $color, true);
        $transition->getOutputArcs()->willReturn([$arc1, $arc2]);

        $expression1 = new Expression('{product: 2}');
        $expression2 = new Expression('{count: count + 1}');
        $arc1->getExpression()->willReturn($expression1);
        $arc2->getExpression()->willReturn($expression2);

        $color1 = new Color([
            'product' => 2,
        ]);
        $color2 = new Color([
            'count' => 3,
        ]);
        $colorfulFactory->createColor([
            'product' => 2,
        ])->willReturn($color1);
        $colorfulFactory->createColor([
            'count' => 3,
        ])->willReturn($color2);

        $expressionEvaluator->evaluate($expression1, $color)->willReturn([
            'product' => 2,
        ]);
        $expressionEvaluator->evaluate($expression2, $color)->willReturn([
            'count' => 3
        ]);

        $color->fromArray([
            'product' => 2,
        ])->shouldBeCalled();

        $color->fromArray([
            'count' => 3,
        ])->shouldBeCalled();

        $placeMarking->removeToken($token)->shouldBeCalledTimes(2);
        $colorfulFactory->createToken()->shouldBeCalledTimes(2)->willReturn($newToken);
        $placeMarking->setTokens([$newToken])->shouldBeCalledTimes(2);
        $this->fire($transition, $marking);
    }

    function it_throws_an_exception_when_new_colors_conflict(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator,
        ExpressionalOutputArcInterface $arc1,
        ExpressionalOutputArcInterface $arc2,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        GuardedTransitionInterface $transition,
        ColorfulMarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color
    ) {
        $this->beConstructedWith($colorfulFactory, $expressionEvaluator);

        $this->mock_is_enabled($expressionEvaluator, [$arc1, $arc2], $place, $placeMarking, $transition, $marking, $token, $color, true);
        $transition->getOutputArcs()->willReturn([$arc1, $arc2]);

        $expression1 = new Expression('{count: count - 1}');
        $expression2 = new Expression('{count: count + 1}');
        $arc1->getExpression()->willReturn($expression1);
        $arc2->getExpression()->willReturn($expression2);

        $color1 = new Color([
            'count' => 1,
        ]);
        $color2 = new Color([
            'count' => 3,
        ]);
        $colorfulFactory->createColor([
            'count' => 1,
        ])->willReturn($color1);
        $colorfulFactory->createColor([
            'count' => 3,
        ])->willReturn($color2);

        $expressionEvaluator->evaluate($expression1, $color)->willReturn([
            'count' => 1,
        ]);
        $expressionEvaluator->evaluate($expression2, $color)->willReturn([
            'count' => 3
        ]);

        $this
            ->shouldThrow(new OutputArcExpressionConflictException("Output arc's expressions conflict."))
            ->duringFire($transition, $marking)
        ;
    }

    private function mock_is_enabled(
        ExpressionEvaluatorInterface $expressionEvaluator,
        array $arcs,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        GuardedTransitionInterface $transition,
        ColorfulMarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color,
        bool $enabled
    ) {
        foreach ($arcs as $arc) {
            $arc->getPlace()->willReturn($place);
            $arc->getWeight()->willReturn(1);
        }

        $placeMarking->getTokens()->willReturn([$token]);
        $marking->getPlaceMarking($place)->willReturn($placeMarking);
        $transition->getInputArcs()->willReturn($arcs);

        $guard = new Expression('true');
        $transition->getGuard()->willReturn($guard);
        $marking->getColor()->willReturn($color);
        $expressionEvaluator->evaluate($guard, $color)->willReturn($enabled);
    }
}
