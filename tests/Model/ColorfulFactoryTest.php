<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\ColorfulFactory;
use SingleColorPetrinet\Model\Expression;

/**
 * @covers \SingleColorPetrinet\Model\ColorfulFactory
 * @covers \SingleColorPetrinet\Model\Color
 * @covers \SingleColorPetrinet\Model\Expression
 */
class ColorfulFactoryTest extends TestCase
{
    public function testCreateColor(): void
    {
        $factory = new ColorfulFactory();
        $this->assertInstanceOf(Color::class, $factory->createColor(['key' => 'value']));
    }

    public function testCreateExpression(): void
    {
        $factory = new ColorfulFactory();
        $this->assertInstanceOf(Expression::class, $factory->createExpression('test', true));
    }
}
