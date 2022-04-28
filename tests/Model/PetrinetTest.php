<?php

namespace SingleColorPetrinet\Tests\Model;

use PHPUnit\Framework\TestCase;
use SingleColorPetrinet\Model\GuardedTransition;
use SingleColorPetrinet\Model\Petrinet;
use SingleColorPetrinet\Model\Place;
use OutOfRangeException;

/**
 * @covers \SingleColorPetrinet\Model\Petrinet
 *
 * @uses \SingleColorPetrinet\Model\Place
 * @uses \SingleColorPetrinet\Model\GuardedTransition
 */
class PetrinetTest extends TestCase
{
    protected Petrinet $petrinet;
    protected array $places;
    protected array $transitions;

    protected function setUp(): void
    {
        $this->petrinet = new Petrinet();
        $this->places = [
            $place1 = new Place(),
            $place2 = new Place(),
        ];
        $place1->setId(1);
        $place2->setId(2);
        $this->petrinet->setPlaces($this->places);
        $this->transitions = [
            $transition1 = new GuardedTransition(),
            $transition2 = new GuardedTransition(),
            $transition3 = new GuardedTransition(),
        ];
        $transition1->setId(1);
        $transition2->setId(2);
        $transition3->setId(3);
        $this->petrinet->setTransitions($this->transitions);
    }

    public function testGetPlaceById(): void
    {
        $this->assertSame($this->places[0], $this->petrinet->getPlaceById(1));
        $this->assertSame($this->places[1], $this->petrinet->getPlaceById(2));
    }

    public function testGetPlaceByInvalidId(): void
    {
        $this->expectExceptionObject(new OutOfRangeException('Place with id 0 not found'));
        $this->petrinet->getPlaceById(0);
    }

    public function testGetTransitionById(): void
    {
        $this->assertSame($this->transitions[0], $this->petrinet->getTransitionById(1));
        $this->assertSame($this->transitions[1], $this->petrinet->getTransitionById(2));
        $this->assertSame($this->transitions[2], $this->petrinet->getTransitionById(3));
    }

    public function testGetTransitionByInvalidId(): void
    {
        $this->expectExceptionObject(new OutOfRangeException('Transition with id 0 not found'));
        $this->petrinet->getTransitionById(0);
    }
}
