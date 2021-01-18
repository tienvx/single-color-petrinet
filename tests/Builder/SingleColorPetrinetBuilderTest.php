<?php

namespace SingleColorPetrinet\Tests\Builder;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Builder\SingleColorPetrinetBuilder;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorInterface;
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
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition());
    }

    public function testCreateTransitionWithGuard(): void
    {
        $guard = fn (ColorInterface $color): bool => true;
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->once())->method('setGuard')->with($guard);
        $transition->expects($this->never())->method('setExpression');
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition($guard));
    }

    public function testCreateTransitionWithExpression(): void
    {
        $expression = fn (ColorInterface $color): array => [];
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->once())->method('setExpression')->with($expression);
        $transition->expects($this->never())->method('setGuard');
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition(null, $expression));
    }

    public function testCreateTransitionWithGuardAndExpression(): void
    {
        $guard = fn (ColorInterface $color): bool => true;
        $expression = fn (ColorInterface $color): array => [];
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->once())->method('setExpression')->with($expression);
        $transition->expects($this->once())->method('setGuard')->with($guard);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition($guard, $expression));
    }
}
