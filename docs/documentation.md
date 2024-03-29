# Documentation

## What is Single Color Petrinet

It is a modification of [Coloured Petrinet](https://en.wikipedia.org/wiki/Coloured_Petri_net). It has everything that
Coloured Petrinet has, but with only one restriction:
* There is only one color in the petrinet at a time

As a result:
* There is only one color stored in marking instead of tokens
* Expressions on output arcs become single expression on transition

That make Single Color Petrinet:
* Not compatible with Coloured Petrinet
* But still backward compatible with Petrinet

## Usage

### Build petrinet

```php
// Instantiates the factory
$factory = new \SingleColorPetrinet\Model\ColorfulFactory();

// Instantiates the petrinet builder
$builder = new \SingleColorPetrinet\Builder\SingleColorPetrinetBuilder($factory);

// Creating a place, with id
$place = $builder->place(0);

// Creating a transition, with id
$transition = $builder->transition(null, null, 0);

// Creating a transition with guard, output expression and id
$transition = $builder->transition(
    fn (\SingleColorPetrinet\Model\ColorInterface $color) => $color->getValue('count') > 1,
    fn (\SingleColorPetrinet\Model\ColorInterface $color) => ['count' => $color->getValue('count') + 1],
    1
);

// Connecting a place to a transition
$builder->connect($place, $transition);

// Connecting a transition to a place with an arc of weight 3
$builder->connect($transition, $place, 3);

// Retrieving the Petrinet
$petrinet = $builder->getPetrinet();
```

### Mark place with tokens

```php
// Instantiates the marking builder
$builder = new \Petrinet\Builder\MarkingBuilder($factory);

// Creates color and sets some values to it
$color = $factory->createColor('{color: 0}');

// Marks a place with the specified tokens number and color
$marking = $builder
    ->mark($place, 3)
    ->getMarking();
$marking->setColor($color);
```

### Fire a transition

```php
// Instantiates the transition service
$transitionService = new \SingleColorPetrinet\Service\GuardedTransitionService($factory);

// Gets all enabled transitions
$transitions = $transitionService->getEnabledTransitions($petrinet, $marking);

// Checks if the transition is enabled in the given marking
$transitionService->isEnabled($transition, $marking);

// Fires the transition in the given marking
try {
    $transitionService->fire($transition, $marking);
} catch (\Petrinet\Service\Exception\TransitionNotEnabledException $e) {
    // The transition is not enabled and cannot be fired
}
```

For more information, please take a look at this [documentation](https://github.com/florianv/petrinet/blob/master/docs/documentation.md).
