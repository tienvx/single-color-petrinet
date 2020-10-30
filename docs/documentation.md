# Documentation

## What is Single Color Petrinet

It is a modification of [Coloured Petrinet](https://en.wikipedia.org/wiki/Coloured_Petri_net). It has everything that
Coloured Petrinet has, but with several restrictions:
* There is only one color in the petrinet at a time
* Expressions of output arcs from a transition should not conflict with each other

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

// Creating a place
$place = $builder->place();

// Creating a transition
$transition = $builder->transition();

// Creating a transition with guard
$transition = $builder->transition($factory->createExpression('count > 1'));

// Connecting a place to a transition
$builder->connect($place, $transition);

// Connecting a transition to a place
$builder->connect($transition, $place);

// Connecting a place to a transition with an arc of weight 3
$builder->connect($place, $transition, 3);

// Connecting a transition to a place with expression
$builder->connect($builder->transition(), $builder->place(), 1, $factory->createExpression('{count: count + 1}'));

// Retrieving the Petrinet
$petrinet = $builder->getPetrinet();
```

### Mark place with tokens

```php
// Instantiates the marking builder
$builder = new \Petrinet\Builder\MarkingBuilder($factory);

// Creates color and sets some values to it
$color = $factory->createColor([
    'count' => 0,
]);

// Marks a place with the specified tokens number and color
$marking = $builder->mark($place, 3)
    ->getMarking()
    ->setColor($color);
```

### Fire a transition

```php
// Instantiates the expression evaluator
$expressionLanguage = new \Symfony\Component\ExpressionLanguage\ExpressionLanguage();
$expressionEvaluator = new \SingleColorPetrinet\Service\ExpressionLanguageEvaluator($expressionLanguage);

// Instantiates the transition service
$transitionService = new \SingleColorPetrinet\Service\GuardedTransitionService($factory, $expressionEvaluator);

// Gets all enabled transitions
$transitions = $transitionService->getEnabledTransitions($petrinet, $marking);

// Checks if the transition is enabled in the given marking
$transitionService->isEnabled($transition, $marking);

// Fires the transition in the given marking
try {
    $transitionService->fire($transition, $marking);
} catch (\Petrinet\Service\Exception\TransitionNotEnabledException $e) {
    // The transition is not enabled and cannot be fired
} catch (\SingleColorPetrinet\Service\Exception\ColorInvalidException $e) {
 // The color's keys and values must be alphanumeric if we use Expression Language
} catch (\SingleColorPetrinet\Service\Exception\OutputArcExpressionConflictException $e) {
  // The output arc's expressions change values of color in different ways
}
```

For more information, please take a look at this [documentation](https://github.com/florianv/petrinet/blob/master/docs/documentation.md).
