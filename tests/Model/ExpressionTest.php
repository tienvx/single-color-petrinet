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
}
