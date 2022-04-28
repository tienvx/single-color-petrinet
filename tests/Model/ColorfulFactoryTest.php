<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\ColorfulFactory;
use SingleColorPetrinet\Model\ColorInterface;

/**
 * @covers \SingleColorPetrinet\Model\ColorfulFactory
 *
 * @uses \SingleColorPetrinet\Model\Color
 */
class ColorfulFactoryTest extends TestCase
{
    public function testCreateColor(): void
    {
        $factory = new ColorfulFactory();
        $this->assertInstanceOf(Color::class, $factory->createColor(['key' => 'value']));
    }

    public function testCreateInvalidColor(): void
    {
        $factory = new ColorfulFactory(\stdClass::class);
        $this->expectExceptionObject(
            new \RuntimeException(sprintf('The color class must implement "%s".', ColorInterface::class))
        );
        $factory->createColor(['key' => 'value']);
    }
}
