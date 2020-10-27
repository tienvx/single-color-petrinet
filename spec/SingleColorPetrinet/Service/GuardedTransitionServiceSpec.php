<?php

namespace spec\SingleColorPetrinet\Service;

use Petrinet\Model\InputArcInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use Petrinet\Model\TokenInterface;
use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\Expression;
use SingleColorPetrinet\Model\ExpressionalOutputArcInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Service\Exception\OutputArcExpressionConflictException;
use SingleColorPetrinet\Service\ExpressionEvaluatorInterface;
use SingleColorPetrinet\Service\ExpressionLanguageEvaluator;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

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
        MarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color
    )
    {
        $this->mock_services($colorfulFactory, $expressionEvaluator, [$arc], $place, $placeMarking, $transition, $marking, $token, $color, true);
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
        MarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color
    )
    {
        $this->mock_services($colorfulFactory, $expressionEvaluator, [$arc], $place, $placeMarking, $transition, $marking, $token, $color, false);
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
        MarkingInterface $marking,
        TokenInterface $token,
        TokenInterface $newToken,
        ColorInterface $color
    )
    {
        $this->beConstructedWith($colorfulFactory, new ExpressionLanguageEvaluator(new ExpressionLanguage()));

        $this->mock_services($colorfulFactory, $expressionEvaluator, [$arc1, $arc2], $place, $placeMarking, $transition, $marking, $token, $color, true);
        $transition->getOutputArcs()->willReturn([$arc1, $arc2]);

        $arc1->getExpression()->willReturn(new Expression('{product: 2}'));
        $arc2->getExpression()->willReturn(new Expression('{count: count + 1}'));

        $color->toArray()->willReturn([
            'product' => '1',
            'count' => '2',
        ]);

        $color->fromArray([
            'product' => '2',
        ])->shouldBeCalled();
        $color->fromArray([
            'count' => '3',
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
        MarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color
    )
    {
        $this->beConstructedWith($colorfulFactory, new ExpressionLanguageEvaluator(new ExpressionLanguage()));

        $this->mock_services($colorfulFactory, $expressionEvaluator, [$arc1, $arc2], $place, $placeMarking, $transition, $marking, $token, $color, true);
        $transition->getOutputArcs()->willReturn([$arc1, $arc2]);

        $arc1->getExpression()->willReturn(new Expression('{count: count + 1}'));
        $arc2->getExpression()->willReturn(new Expression('{count: count - 1}'));
        $color->toArray()->willReturn([
            'count' => '2',
        ]);

        $this
            ->shouldThrow(new OutputArcExpressionConflictException("Output arc's expressions conflict."))
            ->duringFire($transition, $marking)
        ;
    }

    private function mock_services(
        ColorfulFactoryInterface $colorfulFactory,
        ExpressionEvaluatorInterface $expressionEvaluator,
        array $arcs,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking,
        GuardedTransitionInterface $transition,
        MarkingInterface $marking,
        TokenInterface $token,
        ColorInterface $color,
        bool $enabled
    ) {
        foreach ($arcs as $arc) {
            $arc->getPlace()->willReturn($place);
            $arc->getWeight()->willReturn(1);
        }

        $placeMarking->getTokens()->willReturn([$token]);
        $marking->getPlaceMarking($place->getWrappedObject())->willReturn($placeMarking);
        $transition->getInputArcs()->willReturn($arcs);

        $guard = new Expression('true');
        $transition->getGuard()->willReturn($guard);
        $colorfulFactory->getColor()->willReturn($color);
        $expressionEvaluator->evaluate($guard, $color)->willReturn($enabled);
    }
}
