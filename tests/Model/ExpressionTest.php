<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Expression;

/**
 * @covers \SingleColorPetrinet\Model\Expression
 */
class ExpressionTest extends TestCase
{
    public function testTestExpression(): void
    {
        $expression = new Expression('test');
        $this->assertSame('test', $expression->getExpression());
    }

    public function testIsGuard(): void
    {
        $expression = new Expression('test');
        $this->assertSame(false, $expression->isGuard());
        $guard = new Expression('test', true);
        $this->assertSame(true, $guard->isGuard());
    }
}
