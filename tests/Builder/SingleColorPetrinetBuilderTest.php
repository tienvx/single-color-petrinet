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
    public function testCreateTransitionWithoutGuard(): void
    {
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->never())->method('setGuard');
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
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $factory->expects($this->once())->method('createExpression')->with('test guard')->willReturn($guard);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition('test guard'));
    }
}
