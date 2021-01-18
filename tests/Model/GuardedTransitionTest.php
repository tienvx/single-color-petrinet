<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\ColorInterface;
use SingleColorPetrinet\Model\GuardedTransition;

/**
 * @covers \SingleColorPetrinet\Model\GuardedTransition
 */
class GuardedTransitionTest extends TestCase
{
    public function testSetId(): void
    {
        $place = new GuardedTransition();
        $this->assertNull($place->getId());
        $place->setId(123);
        $this->assertSame(123, $place->getId());
    }

    public function testSetGuard(): void
    {
        $guard = fn (ColorInterface $color): bool => true;
        $place = new GuardedTransition();
        $this->assertNull($place->getGuard());
        $place->setGuard($guard);
        $this->assertSame($guard, $place->getGuard());
    }

    public function testSetExpression(): void
    {
        $expression = fn (ColorInterface $color): array => [];
        $place = new GuardedTransition();
        $this->assertNull($place->getGuard());
        $place->setExpression($expression);
        $this->assertSame($expression, $place->getExpression());
    }
}
