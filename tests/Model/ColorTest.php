<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\Color;

/**
 * @covers \SingleColorPetrinet\Model\Color
 */
class ColorTest extends TestCase
{
    public function testGetValues(): void
    {
        $color = new Color(['key' => 'value']);
        $this->assertSame(['key' => 'value'], $color->getValues());
    }

    public function testSetValues(): void
    {
        $color = new Color();
        $this->assertSame([], $color->getValues());
        $color->setValues(['key' => 'value']);
        $this->assertSame(['key' => 'value'], $color->getValues());
    }

    public function testGetValue(): void
    {
        $color = new Color(['key' => 'value']);
        $this->assertSame('value', $color->getValue('key'));
        $this->assertNull($color->getValue('key2'));
    }

    public function testSetValue(): void
    {
        $color = new Color();
        $this->assertSame([], $color->getValues());
        $color->setValue('key', 'value');
        $this->assertSame(['key' => 'value'], $color->getValues());
        $color->setValue('key2', 'value2');
        $this->assertSame(['key' => 'value', 'key2' => 'value2'], $color->getValues());
    }

    public function testMerge(): void
    {
        $color = new Color(['key' => 'value']);
        $this->assertSame(['key' => 'value'], $color->getValues());
        $color->merge(new Color(['key2' => 'value2']));
        $this->assertSame(['key' => 'value', 'key2' => 'value2'], $color->getValues());
    }
}
