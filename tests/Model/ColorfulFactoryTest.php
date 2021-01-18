<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\ColorfulFactory;

/**
 * @covers \SingleColorPetrinet\Model\ColorfulFactory
 * @covers \SingleColorPetrinet\Model\Color
 */
class ColorfulFactoryTest extends TestCase
{
    public function testCreateColor(): void
    {
        $factory = new ColorfulFactory();
        $this->assertInstanceOf(Color::class, $factory->createColor(['key' => 'value']));
    }
}
