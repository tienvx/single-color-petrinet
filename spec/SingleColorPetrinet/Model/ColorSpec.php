<?php

namespace spec\SingleColorPetrinet\Model;

use PhpSpec\ObjectBehavior;
use SingleColorPetrinet\Model\Color;

class ColorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SingleColorPetrinet\Model\Color');
    }

    function it_set_a_value()
    {
        $this->has('test')->shouldReturn(false);
        $this->get('test')->shouldReturn(null);
        $this->set('test', 'test value');
        $this->has('test')->shouldReturn(true);
        $this->get('test')->shouldReturn('test value');
    }

    function it_convert_to_array()
    {
        $this->set('test1', 'value1');
        $this->set('test2', '2');
        $this->set('test3', 'value 3');

        $this->toArray()->shouldReturn([
            'test1' => 'value1',
            'test2' => '2',
            'test3' => 'value 3',
        ]);
    }

    function it_load_from_array()
    {
        $this->get('test1')->shouldReturn(null);
        $this->get('test2')->shouldReturn(null);
        $this->get('test3')->shouldReturn(null);

        $this->fromArray([
            'test1' => 'value1',
            'test2' => '2',
            'test3' => 'value 3',
        ]);

        $this->get('test1')->shouldReturn('value1');
        $this->get('test2')->shouldReturn('2');
        $this->get('test3')->shouldReturn('value 3');
    }

    function it_conflicts_with_other_color()
    {
        $this->set('test1', 'value1');

        $this->conflict(new Color([
            'test1' => 'value2',
        ]))->shouldReturn(true);
    }

    function it_does_not_conflict_with_other_color()
    {
        $this->set('test1', 'value1');

        $this->conflict(new Color([
            'test1' => 'value1',
        ]))->shouldReturn(false);
    }
}
