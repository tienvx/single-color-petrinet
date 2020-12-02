<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Color;

class ColorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(['count' => '1']);
        $this->shouldHaveType('SingleColorPetrinet\Model\Color');
    }

    function it_set_get_values()
    {
        $this->beConstructedWith(['count' => '1']);
        $this->setValues(['product' => '2']);
        $this->getValues()->shouldReturn([
            'product' => '2',
        ]);
    }

    function it_conflicts_with_other_color()
    {
        $this->beConstructedWith([
            'test1' => 'value1',
        ]);

        $this->conflict(new Color([
            'test1' => 'value2',
        ]))->shouldReturn(true);
    }

    function it_does_not_conflict_with_other_color()
    {
        $this->beConstructedWith([
            'test1' => 'value1',
        ]);

        $this->conflict(new Color([
            'test1' => 'value1',
        ]))->shouldReturn(false);
    }

    function it_merges_with_other_color()
    {
        $this->beConstructedWith([
            'test1' => 'value1',
        ]);

        $this->merge(new Color([
            'test1' => 'value2',
            'test2' => 'value1',
        ]));

        $this->getValues()->shouldReturn([
            'test1' => 'value2',
            'test2' => 'value1',
        ]);
    }
}
