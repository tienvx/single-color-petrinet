<?php

namespace SingleColorPetrinet\Tests\Service;

use Petrinet\Model\MarkingInterface;
use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\Transition;
use Petrinet\Model\TransitionInterface;
use Petrinet\Service\TransitionServiceInterface;
use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorfulMarkingInterface;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Service\ExpressionEvaluatorInterface;
use SingleColorPetrinet\Service\GuardedTransitionService;

/**
 * @covers \SingleColorPetrinet\Service\GuardedTransitionService
 */
class GuardedTransitionServiceTest extends TestCase
{
    public function testGetEnabledTransitions(): void
    {
        $transitions = [
            $transition1 = new Transition(),
            $transition2 = new Transition(),
            $transition3 = new Transition(),
        ];
        $petrinet = $this->createMock(PetrinetInterface::class);
        $petrinet->expects($this->once())->method('getTransitions')->willReturn($transitions);
        $marking = $this->createMock(MarkingInterface::class);
        $service = $this->createPartialMock(GuardedTransitionService::class, ['isEnabled']);
        $service->expects($this->exactly(3))->method('isEnabled')->withConsecutive(
            [$transition1, $marking],
            [$transition2, $marking],
            [$transition3, $marking],
        )->willReturnOnConsecutiveCalls(true, false, true);
        $this->assertSame([$transition1, $transition3], $service->getEnabledTransitions($petrinet, $marking));
    }

    public function testIsNotEnabledByDecoratedService(): void
    {
        $transition = $this->createMock(TransitionInterface::class);
        $marking = $this->createMock(MarkingInterface::class);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $evaluator = $this->createMock(ExpressionEvaluatorInterface::class);
        $decorated = $this->createMock(TransitionServiceInterface::class);
        $decorated->expects($this->once())->method('isEnabled')->with($transition, $marking)->willReturn(false);
        $service = new GuardedTransitionService($factory, $evaluator, $decorated);
        $this->assertFalse($service->isEnabled($transition, $marking));
    }

    public function testIsEnabledByDecoratedService(): void
    {
        $transition = $this->createMock(TransitionInterface::class);
        $marking = $this->createMock(MarkingInterface::class);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $evaluator = $this->createMock(ExpressionEvaluatorInterface::class);
        $decorated = $this->createMock(TransitionServiceInterface::class);
        $decorated->expects($this->once())->method('isEnabled')->with($transition, $marking)->willReturn(true);
        $service = new GuardedTransitionService($factory, $evaluator, $decorated);
        $this->assertTrue($service->isEnabled($transition, $marking));
    }

    public function testIsNotEnabledByGuard(): void
    {
        $guard = $this->createMock(ExpressionInterface::class);
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->exactly(2))->method('getGuard')->willReturn($guard);
        $color = $this->createMock(ColorInterface::class);
        $marking = $this->createMock(ColorfulMarkingInterface::class);
        $marking->expects($this->once())->method('getColor')->willReturn($color);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $evaluator = $this->createMock(ExpressionEvaluatorInterface::class);
        $evaluator->expects($this->once())->method('evaluate')->with($guard, $color)->willReturn(false);
        $decorated = $this->createMock(TransitionServiceInterface::class);
        $decorated->expects($this->once())->method('isEnabled')->with($transition, $marking)->willReturn(true);
        $service = new GuardedTransitionService($factory, $evaluator, $decorated);
        $this->assertFalse($service->isEnabled($transition, $marking));
    }

    public function testIsEnabledByGuard(): void
    {
        $guard = $this->createMock(ExpressionInterface::class);
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->exactly(2))->method('getGuard')->willReturn($guard);
        $color = $this->createMock(ColorInterface::class);
        $marking = $this->createMock(ColorfulMarkingInterface::class);
        $marking->expects($this->once())->method('getColor')->willReturn($color);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $evaluator = $this->createMock(ExpressionEvaluatorInterface::class);
        $evaluator->expects($this->once())->method('evaluate')->with($guard, $color)->willReturn(true);
        $decorated = $this->createMock(TransitionServiceInterface::class);
        $decorated->expects($this->once())->method('isEnabled')->with($transition, $marking)->willReturn(true);
        $service = new GuardedTransitionService($factory, $evaluator, $decorated);
        $this->assertTrue($service->isEnabled($transition, $marking));
    }

    public function testFire(): void
    {
        $transition = $this->createMock(TransitionInterface::class);
        $marking = $this->createMock(MarkingInterface::class);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $evaluator = $this->createMock(ExpressionEvaluatorInterface::class);
        $decorated = $this->createMock(TransitionServiceInterface::class);
        $decorated->expects($this->once())->method('fire')->with($transition, $marking);
        $service = new GuardedTransitionService($factory, $evaluator, $decorated);
        $service->fire($transition, $marking);
    }
}
