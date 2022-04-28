<?php

namespace SingleColorPetrinet\Tests\Builder;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Builder\SingleColorPetrinetBuilder;
use SingleColorPetrinet\Model\ColorfulFactoryInterface;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\GuardedTransitionInterface;
use SingleColorPetrinet\Model\PetrinetInterface;
use SingleColorPetrinet\Model\PlaceInterface;
use UnexpectedValueException;

/**
 * @covers \SingleColorPetrinet\Builder\SingleColorPetrinetBuilder
 */
class SingleColorPetrinetBuilderTest extends TestCase
{
    /**
     * @testWith [false, false, false]
     *           [true, false, false]
     *           [true, true, false]
     *           [true, false, true]
     *           [true, true, false]
     *           [true, false, true]
     *           [false, true, true]
     *           [true, true, true]
     */
    public function testCreateTransition(bool $hasGuard, bool $hasExpression, bool $hasId): void
    {
        $guard = $hasGuard ? fn (ColorInterface $color): bool => true : null;
        $expression = $hasExpression ? fn (ColorInterface $color): array => [] : null;
        $id = $hasId ? 123 : null;
        $transition = $this->createMock(GuardedTransitionInterface::class);
        $transition->expects($this->exactly($hasGuard))->method('setGuard')->with($guard);
        $transition->expects($this->exactly($hasExpression))->method('setExpression')->with($expression);
        $transition->expects($this->exactly($hasId))->method('setId')->with($id);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createTransition')->willReturn($transition);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($transition, $builder->transition($guard, $expression, $id));
    }

    /**
     * @testWith [false]
     *           [true]
     */
    public function testCreatePlace(bool $hasId): void
    {
        $id = $hasId ? 123 : null;
        $place = $this->createMock(PlaceInterface::class);
        $place->expects($this->exactly($hasId))->method('setId')->with($id);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createPlace')->willReturn($place);
        $builder = new SingleColorPetrinetBuilder($factory);
        $this->assertSame($place, $builder->place($id));
    }

    /**
     * @testWith ["SingleColorPetrinet\\Model\\PetrinetInterface"]
     *           ["Petrinet\\Model\\PetrinetInterface"]
     */
    public function testGetPetrinet(string $petrinetClass): void
    {
        $petrinet = $this->createMock($petrinetClass);
        $factory = $this->createMock(ColorfulFactoryInterface::class);
        $factory->expects($this->once())->method('createPetrinet')->willReturn($petrinet);
        $builder = new SingleColorPetrinetBuilder($factory);
        if (PetrinetInterface::class !== $petrinetClass) {
            $this->expectExceptionObject(
                new UnexpectedValueException(
                    sprintf('Factory must return petrinet instance of %s', PetrinetInterface::class)
                )
            );
        }
        $this->assertSame($petrinet, $builder->getPetrinet());
    }
}
