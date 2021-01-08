<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Place;

/**
 * @covers \SingleColorPetrinet\Model\Place
 */
class PlaceTest extends TestCase
{
    public function testSetId(): void
    {
        $place = new Place();
        $this->assertNull($place->getId());
        $place->setId(123);
        $this->assertSame(123, $place->getId());
    }
}
