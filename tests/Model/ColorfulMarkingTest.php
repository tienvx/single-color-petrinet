<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;
use SingleColorPetrinet\Model\ColorfulMarking;

/**
 * @covers \SingleColorPetrinet\Model\ColorfulMarking
 *
 * @uses \SingleColorPetrinet\Model\Color
 */
class ColorfulMarkingTest extends TestCase
{
    public function testSetColor(): void
    {
        $color = new Color();
        $marking = new ColorfulMarking();
        $marking->setColor($color);
        $this->assertSame($color, $marking->getColor());
    }
}
