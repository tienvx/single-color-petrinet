<?php

namespace SingleColorPetrinet\Tests\Builder;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Builder\SingleColorPetrinetBuilder;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ExpressionInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;

/**
 * @covers \SingleColorPetrinet\Builder\SingleColorPetrinetBuilder
 */
class SingleColorPetrinetBuilderTest extends TestCase
{
    public function testCreateTransitionWithoutGuardAndExpression(): void
    {
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->never())->method('setGuard');
        $transition->expects($this->never())->method('setExpression');
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $factory->expects($this->never())->method('createExpression');
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition());
    }

    public function testCreateTransitionWithGuard(): void
    {
        $guard = $this->createMock(ExpressionInterface::class);
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->once())->method('setGuard')->with($guard);
        $transition->expects($this->never())->method('setExpression');
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $factory->expects($this->once())->method('createExpression')->with('test guard', true)->willReturn($guard);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition('test guard'));
    }

    public function testCreateTransitionWithExpression(): void
    {
        $expression = $this->createMock(ExpressionInterface::class);
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->once())->method('setExpression')->with($expression);
        $transition->expects($this->never())->method('setGuard');
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $factory->expects($this->once())->method('createExpression')->with(
            'test expression',
            false
        )->willReturn($expression);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition(null, 'test expression'));
    }

    public function testCreateTransitionWithGuardAndExpression(): void
    {
        $guard = $this->createMock(ExpressionInterface::class);
        $expression = $this->createMock(ExpressionInterface::class);
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->once())->method('setExpression')->with($expression);
        $transition->expects($this->once())->method('setGuard')->with($guard);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $factory->expects($this->exactly(2))->method('createExpression')->withConsecutive(
            ['test guard', true],
            ['test expression', false],
        )->willReturnOnConsecutiveCalls($guard, $expression);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition('test guard', 'test expression'));
    }
}
